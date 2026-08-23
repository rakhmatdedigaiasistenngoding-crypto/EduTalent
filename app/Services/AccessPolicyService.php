<?php

namespace App\Services;

use App\Models\Identity;
use Carbon\Carbon;

class AccessPolicyService
{
    /**
     * Check if the given identity can be linked to a personal account.
     */
    public function canLinkToPersonal(Identity $identity, array $context): bool
    {
        // Cek konteks 'mode'
        if (isset($context['mode']) && $context['mode'] === 'corporate_recruitment') {
            return false;
        }

        // Jika identity_type = 'anonymous'
        if ($identity->identity_type === 'anonymous') {
            return true;
        }

        // Jika identity_type = 'student'
        if ($identity->identity_type === 'student') {
            if ($identity->status === 'graduated' && !empty($identity->ended_at)) {
                $endedAt = Carbon::parse($identity->ended_at);
                
                // Cek apakah ended_at > 1 tahun yang lalu
                if ($endedAt->copy()->addYear()->isPast()) {
                    return false;
                }
            }
            return true;
        }

        // Default
        return true;
    }
}
