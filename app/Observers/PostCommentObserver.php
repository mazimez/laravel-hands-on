<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\PostComment;

class PostCommentObserver
{
    /**
     * Handle the PostComment "created" event.
     *
     * @param  \App\Models\PostComment  $post_comment
     * @return void
     */
    public function created(PostComment $post_comment)
    {
        $overall_post_comment_count = PostComment::whereHas('post', function ($query) use ($post_comment) {
            $query->where('user_id', $post_comment->post->user_id)
                ->whereColumn('posts.user_id', '!=', 'post_comments.user_id');
        })->count();
        if ($overall_post_comment_count > 0) {
            $first_comment_badge = Badge::where('slug', Badge::FIRST_COMMENT)->first();
            if ($first_comment_badge) {
                $user_to_give_badge = $post_comment->post->user;
                if (! $user_to_give_badge->badges()->where('badges.id', $first_comment_badge->id)->exists()) {
                    $post_comment->badges()->create([
                        'user_id' => $post_comment->post->user_id,
                        'badge_id' => $first_comment_badge->id,
                    ]);
                }
            }
        }
    }

    /**
     * Handle the PostComment "updated" event.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return void
     */
    public function updated(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the PostComment "deleted" event.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return void
     */
    public function deleted(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the PostComment "restored" event.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return void
     */
    public function restored(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the PostComment "force deleted" event.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return void
     */
    public function forceDeleted(PostComment $postComment)
    {
        //
    }
}
