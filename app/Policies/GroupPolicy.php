<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('User_viewAny');
    }

    public function view(User $user)
    {
        return $user->hasPermission('User_view');
    }

    public function create(User $user)
    {
         return $user->hasPermission('User_create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('User_update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('User_delete');
    }

    public function status(User $user)
    {
        return $user->hasPermission('User_status');
    }

    public function export(User $user)
    {
        return $user->hasPermission('User_export');
    }

    public function import(User $user)
    {
        return $user->hasPermission('User_import');
    }
}
