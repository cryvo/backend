<?php
// app/Policies/FeeTierPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\FeeTier;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeeTierPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
