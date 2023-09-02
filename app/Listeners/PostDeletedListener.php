<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;
use App\Mail\PostDeletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PostDeletedListener
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
     * @param  \App\Events\PostDeletedEvent  $event
     * @return void
     */
    public function handle(PostDeletedEvent $event)
    {
        Mail::to($event->user_email)
            ->send(new PostDeletedMail($event->post_title, $event->deletion_reason));
    }
}
