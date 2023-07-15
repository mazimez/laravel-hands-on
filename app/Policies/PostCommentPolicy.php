<?php

namespace App\Policies;

use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\PostComment;
use App\Models\User;

class PostCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Post $post)
    {
        if ($post->is_blocked) {
            return $this->deny(__('messages.post_blocked_can_not_see_comments'));
        }
        if (!$post->is_verified) {
            return $this->deny(__('messages.post_not_verified_can_not_see_comments'));
        }
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PostComment $postComment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Post $post)
    {
        if ($post->is_blocked) {
            return $this->deny(__('messages.post_blocked_can_not_add_comments'));
        }
        if (!$post->is_verified) {
            return $this->deny(__('messages.post_not_verified_can_not_add_comments'));
        }
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PostComment $postComment, Post $post)
    {
        if ($post->is_blocked) {
            return $this->deny(__('messages.post_blocked_can_not_add_comments'));
        }
        if (!$post->is_verified) {
            return $this->deny(__('messages.post_not_verified_can_not_add_comments'));
        }
        if ($postComment->post_id != $post->id) {
            return $this->deny(__('messages.comment_does_not_belong_to_post'));
        }
        if ($postComment->user_id != $user->id) {
            return $this->deny(__('messages.not_your_comment'));
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PostComment $postComment, Post $post)
    {
        if ($post->is_blocked) {
            return $this->deny(__('messages.post_blocked_can_not_add_comments'));
        }
        if (!$post->is_verified) {
            return $this->deny(__('messages.post_not_verified_can_not_add_comments'));
        }
        if ($postComment->post_id != $post->id) {
            return $this->deny(__('messages.comment_does_not_belong_to_post'));
        }
        if ($postComment->user_id != $user->id) {
            return $this->deny(__('messages.not_your_comment'));
        }
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PostComment $postComment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PostComment $postComment)
    {
        //
    }
}
