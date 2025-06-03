<?php
// app/Policies/FaqPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Faq;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->hasRole('admin');
    }
}
