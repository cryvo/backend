<?php
// app/Policies/ReferralPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReferralPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
