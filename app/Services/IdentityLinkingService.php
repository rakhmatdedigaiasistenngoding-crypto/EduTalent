<?php

namespace App\Services;

use App\Models\User;
use App\Models\Identity;

use Illuminate\Support\Facades\DB;

class IdentityLinkingService
{
    public function __construct(
        protected IdentityTokenService $tokenService,
        protected AccessPolicyService $accessPolicy
    ) {}

    public function linkByToken(string $token, User $user): bool
    {
        try {
            // [FIX TEMUAN-3] Satu transaksi tunggal — tidak nested
            return DB::transaction(function () use ($token, $user) {
                // 1. Validate token (requires active transaction for lockForUpdate)
                $identityToken = $this->tokenService->validate($token);

                if (!$identityToken) {
                    return false;
                }

                // 2. Ambil source identity (dari token)
                $sourceIdentity = $identityToken->identity;

                if (!$sourceIdentity) {
                    throw new \Exception('Source identity not found');
                }

                // 3. Lakukan linking — langsung tanpa buka transaksi baru
                $this->performLink($sourceIdentity, $user);

                // 4. Mark token as used
                $this->tokenService->markAsUsed($identityToken);

                return true;
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Identity token linking failed', [
                'error'   => $e->getMessage(),
                'token'   => $token,
                'user_id' => $user->id,
            ]);

            return false;
        }
    }

    /**
     * Link an existing anonymous identity directly to a user's personal identity.
     * Catatan: Gunakan method ini hanya jika sudah berada dalam konteks transaksi.
     * Untuk linking dengan transaksi baru gunakan linkByToken().
     */
    public function linkIdentity(Identity $sourceIdentity, User $user): bool
    {
        // [FIX TEMUAN-3] Bungkus dalam transaksi HANYA jika dipanggil secara mandiri (bukan dari linkByToken)
        return DB::transaction(function () use ($sourceIdentity, $user) {
            return $this->performLink($sourceIdentity, $user);
        });
    }

    /**
     * [FIX TEMUAN-3] Core logic linking — dipanggil tanpa membuka transaksi baru.
     * Dapat dipanggil di dalam transaksi yang sudah ada (dari linkByToken atau linkIdentity).
     */
    protected function performLink(Identity $sourceIdentity, User $user): bool
    {
        // Mencegah double linking
        if ($sourceIdentity->linked_to_identity_id) {
            throw new \Exception('Identity already linked');
        }

        // Ambil / buat personal identity
        $personalIdentity = Identity::firstOrCreate(
            [
                'user_id'       => $user->id,
                'identity_type' => Identity::TYPE_PERSONAL,
            ],
            [
                'status'     => 'active',
                'started_at' => now(),
            ]
        );

        // Mencegah self linking
        if ($sourceIdentity->id === $personalIdentity->id) {
            throw new \Exception('Cannot link identity to itself');
        }

        // Cek policy
        if (!$this->accessPolicy->canLinkToPersonal($sourceIdentity, [
            'mode'      => $sourceIdentity->mode ?? null,
            'tenant_id' => $sourceIdentity->tenant_id ?? null,
        ])) {
            throw new \Exception('Policy rejected linking');
        }

        // Update: set linked_to_identity_id (tidak mengganggu data lain)
        $sourceIdentity->update([
            'linked_to_identity_id' => $personalIdentity->id,
        ]);

        // [STEP-36B] Log Aktivitas: Identity Linking
        \Illuminate\Support\Facades\Log::info('identity_linked', [
            'source_identity_id' => $sourceIdentity->id,
            'target_identity_id' => $personalIdentity->id,
            'user_id' => $user->id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return true;
    }

    /**
     * Auto link identity after login using a session token.
     */
    public function autoLink(User $user, string $token): bool
    {
        return $this->linkByToken($token, $user);
    }
}
