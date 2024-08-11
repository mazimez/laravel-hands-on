<?php

namespace App\Policies;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, File $file): bool
    {
        return true;
    }

    public function viewUserFiles(User $user, User $user_to_check)
    {
        if ($user->type == User::ADMIN) {
            return true;
        }
        if ($user->id != $user_to_check->id) {
            return $this->deny(__('messages.can_not_view_someone_else_files'));
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, File $file): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, File $file): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model(for post).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deletePostFile(User $user, File $file, Post $post)
    {
        if (!$file->post) {
            return $this->deny(__('messages.file_does_not_belongs_to_any_post'));
        }

        if ($post->id != $file->post->id) {
            return $this->deny(__('messages.file_does_not_belong_to_post'));
        }
        if ($user->type == User::ADMIN) {
            return true;
        }
        if ($user->id != $post->user_id) {
            return $this->deny(__('messages.not_your_post'));
        }
        if ($user->id != $file->user_id) {
            return $this->deny(__('messages.not_your_file'));
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model(for user).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteUserFile(User $user, File $file, User $user_to_check)
    {
        if (!$file->user) {
            return $this->deny(__('messages.file_does_not_belongs_to_any_user'));
        }

        if ($user_to_check->id != $file->user->id) {
            return $this->deny(__('messages.file_does_not_belong_to_user'));
        }
        if ($user->type == User::ADMIN) {
            return true;
        }
        if ($user->id != $file->user_id) {
            return $this->deny(__('messages.not_your_file'));
        }
        return true;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, File $file): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, File $file): bool
    {
        return true;
    }
}
