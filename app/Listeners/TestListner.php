<?php

namespace App\Listeners;

use App\Events\TestEvent;

class TestListner
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
     * @param  \App\Events\TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        //
    }
}
