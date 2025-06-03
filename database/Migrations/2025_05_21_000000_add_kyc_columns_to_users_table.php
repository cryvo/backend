<?php
// File: backend/app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $fillable = [
        'uid',
        'name',
        'email',
        'password',
        'kyc_document_path',
        'kyc_selfie_path',
        'kyc_status',
        // ... other fillable fields
    ];

    /**
     * Auto‐generate a UUID for `uid` if not set.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->uid)) {
                $user->uid = (string) Str::uuid();
            }
        });
    }

    /**
     * Accessors for KYC file URLs (private storage).
     */
    public function getKycDocumentUrlAttribute()
    {
        return $this->kyc_document_path
            ? \Storage::disk('private')->url($this->kyc_document_path)
            : null;
    }

    public function getKycSelfieUrlAttribute()
    {
        return $this->kyc_selfie_path
            ? \Storage::disk('private')->url($this->kyc_selfie_path)
            : null;
    }
}
