<?php
// app/Policies/DepositPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Deposit;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepositPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
