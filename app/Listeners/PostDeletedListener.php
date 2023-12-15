<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;
use App\Mail\PostDeletedMail;
use App\Traits\ErrorManager;
use Illuminate\Support\Facades\Mail;

class PostDeletedListener
{
    use ErrorManager;

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
        try {
            Mail::to($event->user_email)
                ->send(new PostDeletedMail($event->post_title, $event->deletion_reason));
        } catch (\Throwable $th) {
            ErrorManager::registerError($th->getMessage(), __FILE__, $th->getLine(), $th->getFile());
        }
    }
}
