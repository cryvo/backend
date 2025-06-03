<?php
// app/Policies/KycPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Kyc;
use Illuminate\Auth\Access\HandlesAuthorization;

class KycPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
