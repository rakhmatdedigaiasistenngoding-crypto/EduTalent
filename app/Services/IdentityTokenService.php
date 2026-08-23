<?php

namespace App\Services;

use App\Models\Identity;
use App\Models\IdentityToken;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class IdentityTokenService
{
    /**
     * Generate a new identity token
     */
    public function generate(Identity $identity, string $type = 'linking'): IdentityToken
    {
        $expiresAt = match ($type) {
            'otp' => now()->addMinutes(15),
            default => now()->addDays(7), // linking and others
        };

        do {
            $token = Str::random(48);
        } while (IdentityToken::where('token', $token)->exists());

        return IdentityToken::create([
            'identity_id' => $identity->id,
            'token' => $token,
            'type' => $type,
            'expires_at' => $expiresAt,
        ]);
    }

    /**
     * Validate an existing token (requires active DB transaction)
     */
    public function validate(string $token): ?IdentityToken
    {
        if (!DB::transactionLevel()) {
            throw new \RuntimeException('validate() must be called inside a transaction');
        }

        $identityToken = IdentityToken::where('token', $token)->lockForUpdate()->first();

        if (!$identityToken) {
            return null;
        }

        // [FIX TEMUAN-2] isValid() kini sudah mengecek: used_at, expires_at, dan attempts < 5
        if ($identityToken->isValid()) {
            return $identityToken;
        }

        // Increment attempts setiap kali token digunakan tetapi tidak valid
        $identityToken->increment('attempts');

        return null;
    }

    /**
     * Mark a token as used
     */
    public function markAsUsed(IdentityToken $token): void
    {
        $token->update([
            'used_at' => now(),
        ]);
    }
}
