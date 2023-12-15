<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserFollows;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserFollowsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user toggle the follow action
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function toggle(User $auth_user, User $user_to_follow)
    {
        if ($auth_user->id == $user_to_follow->id) {
            return $this->deny(__('messages.can_not_follow_self'));
        }

        return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserFollows  $userFollows
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserFollows $userFollows)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserFollows  $userFollows
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserFollows $userFollows)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserFollows  $userFollows
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserFollows $userFollows)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserFollows  $userFollows
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserFollows $userFollows)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserFollows  $userFollows
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserFollows $userFollows)
    {
        //
    }
}
