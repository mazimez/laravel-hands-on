<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\File;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if ($post->user) {
            $user = $post->user;
            if ($user->posts()->count() <= 0) {
                $first_post_badge = Badge::where('slug', Badge::FIRST_POST)->first();
                if ($first_post_badge) {
                    if (!$user->badges()->where('badges.id', $first_post_badge->id)->exists()) {
                        $post->badges()->create([
                            'user_id' => $post->user->id,
                            'badge_id' => $first_post_badge->id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        File::destroy($post->files()->get()->pluck('id'));
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
