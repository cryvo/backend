<?php
// app/Policies/WithdrawalPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawalPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
