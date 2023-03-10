<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Event_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Supplier  $user\
     * @param  \App\Models\Supplier  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->hasPermission('Event_view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
         return $user->hasPermission('Event_create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Supplier  $user
     * @param  \App\Models\Supplier  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('Event_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Supplier  $user
     * @param  \App\Models\Supplier  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('Event_delete');
    }
    public function export(User $user)
    {
        return $user->hasPermission('Event_export');
    }

    public function import(User $user)
    {
        return $user->hasPermission('Event_import');
    }




}
