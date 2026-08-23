<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityToken extends Model
{
    protected $fillable = [
        'identity_id', 'token', 'type',
        'expires_at', 'used_at', 'attempts'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    /**
     * [FIX TEMUAN-2] Cek apakah token masih valid.
     * Validasi mencakup: belum digunakan, belum kadaluarsa, dan belum melebihi batas percobaan.
     * Enkapsulasi penuh agar aman jika dipanggil dari mana saja.
     */
    public function isValid(): bool
    {
        return is_null($this->used_at)
            && now()->lt($this->expires_at)
            && $this->attempts < 5; // [FIX TEMUAN-2] Rate-limit check
    }
}
