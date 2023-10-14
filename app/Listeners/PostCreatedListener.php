<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Mail\PostCreatedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PostCreatedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostCreatedEvent  $event
     * @return void
     */
    public function handle(PostCreatedEvent $event)
    {
        $post_owner = $event->post->user;

        $users = User::where('type', User::USER)
            ->where('id', '!=', $post_owner->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();
        foreach ($users as $user_to_send_mail) {
            Mail::to($user_to_send_mail->email)
                ->send(new PostCreatedMail($event->post->title, $post_owner->name));
        }
    }
}
