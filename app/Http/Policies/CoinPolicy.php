<?php
// app/Policies/CoinPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Coin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoinPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
