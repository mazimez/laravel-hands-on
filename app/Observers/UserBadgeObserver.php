<?php

namespace App\Observers;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\UserBadge;

class UserBadgeObserver
{
    /**
     * Handle the UserBadge "created" event.
     *
     * @param  \App\Models\UserBadge  $userBadge
     * @return void
     */
    public function created(UserBadge $userBadge)
    {
        $notification = $userBadge->notifications()->create([
            'user_id' => $userBadge->user_id,
            'title' => __('notification_messages.badge_added_title'),
            'message' => __('notification_messages.badge_added_message', ['badge_name' => $userBadge->badge->name]),
            'type' => Notification::NEW_BADGE_ADDED,
            'click_action' => Notification::OPEN_PROFILE,
            'meta_data' => [
                'badge_id' => $userBadge->badge->id,
            ],
        ]);
        SendNotificationJob::dispatch($notification);
    }

    /**
     * Handle the UserBadge "updated" event.
     *
     * @param  \App\Models\UserBadge  $userBadge
     * @return void
     */
    public function updated(UserBadge $userBadge)
    {
        //
    }

    /**
     * Handle the UserBadge "deleted" event.
     *
     * @param  \App\Models\UserBadge  $userBadge
     * @return void
     */
    public function deleted(UserBadge $userBadge)
    {
        //
    }

    /**
     * Handle the UserBadge "restored" event.
     *
     * @param  \App\Models\UserBadge  $userBadge
     * @return void
     */
    public function restored(UserBadge $userBadge)
    {
        //
    }

    /**
     * Handle the UserBadge "force deleted" event.
     *
     * @param  \App\Models\UserBadge  $userBadge
     * @return void
     */
    public function forceDeleted(UserBadge $userBadge)
    {
        //
    }
}
