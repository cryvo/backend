<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function view(User $admin, User $user)
    {
        return $admin->hasRole('admin');
    }

    public function create(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function update(User $admin, User $user)
    {
        return $admin->hasRole('admin');
    }

    public function delete(User $admin, User $user)
    {
        return $admin->hasRole('admin');
    }
}
