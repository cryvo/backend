<?php
// app/Policies/ApiKeyPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\ApiKey;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiKeyPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
