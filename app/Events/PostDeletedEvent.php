<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post_title;
    public $deletion_reason;
    public $user_email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post_title, $deletion_reason, $user_email)
    {
        $this->post_title = $post_title;
        $this->deletion_reason = $deletion_reason;
        $this->user_email = $user_email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('laravel-hands-on');
    }
}