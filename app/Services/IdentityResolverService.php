<?php

namespace App\Services;

use App\Models\Identity;
use Illuminate\Support\Facades\Auth;

class IdentityResolverService
{
    public function __construct(
        protected IdentityTokenService $tokenService
    ) {}

    /**
     * Menentukan dan mengambil identitas user (Personal atau Anonymous).
     * 
     * @param array $context ['tenant_id' => ..., 'session_id' => ...]
     * @return Identity
     */
    public function resolve(array $context = []): Identity
    {
        // 1. Ambil data dasar dengan fallback
        $user = Auth::user();
        $tenantId = $context['tenant_id'] ?? null;
        $sessionId = $context['session_id'] ?? session()->getId();

        // 2. Jika User Login -> Resolusi Identity PERSONAL
        if ($user) {
            return Identity::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'identity_type' => Identity::TYPE_PERSONAL,
                ],
                [
                    'status' => 'active',
                    'started_at' => now(),
                    // Tenant ID opsional untuk personal karena bersifat global (lifelong tracking)
                    'tenant_id' => $tenantId, 
                ]
            );
        }

        // 3. Jika Guest -> Cek apakah sudah ada identitas untuk session ini (dari form login/identitas)
        $identity = Identity::where('session_id', $sessionId)
            ->where('status', 'active')
            ->first();

        // 4. Fallback: Buat/Ambil Identity ANONYMOUS jika belum ada data dari form
        if (!$identity) {
            $identity = Identity::firstOrCreate(
                [
                    'identity_type' => Identity::TYPE_ANONYMOUS,
                    'external_id' => $sessionId,
                    'tenant_id' => $tenantId,
                ],
                [
                    'session_id' => $sessionId,
                    'status' => 'active',
                    'started_at' => now(),
                ]
            );
        }

        // ✔ Setelah hasil guest & Saat student/candidate dibuat
        // Generate Token jika identitas baru saja dibuat (bukan Personal)
        if ($identity->wasRecentlyCreated) {
            $token = $this->tokenService->generate($identity);
            session()->put('assessment_token', $token->token);
        }

        return $identity;
    }

    /**
     * Mendeteksi kemungkinan user sudah pernah melakukan asesmen.
     * Dicari berdasarkan session berjalan (device) jika user sudah login.
     */
    public function detectPotentialIdentity()
    {
        // Hanya relevan dideteksi bagi user yang sudah Auth (Personal) 
        // untuk mencari identitas Anonymous miliknya yang belum dilink.
        if (Auth::check()) {
            $sessionId = session()->getId();
            
            return Identity::where('identity_type', Identity::TYPE_ANONYMOUS)
                ->where('external_id', $sessionId)
                ->whereNull('linked_to_identity_id')
                ->first();
        }

        return null;
    }
}
