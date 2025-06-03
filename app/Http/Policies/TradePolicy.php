<?php
// app/Policies/TradePolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Trade;
use Illuminate\Auth\Access\HandlesAuthorization;

class TradePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
