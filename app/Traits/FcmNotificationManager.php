<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait FcmNotificationManager
{
    /**
     * send notification to firebase tokens
     *
     * @param  array  $firebase_tokens firebase tokens
     * @param  string  $title title of the notification
     * @param  string  $message message of the notification
     * @param  string  $click_action click action of notification
     * @param  array|null  $meta_data meta-data for notification in array
     * @param  string|null  $image_url url of the image for notification
     */
    public static function sendNotification($firebase_tokens, $title, $message, $click_action = 'DEFAULT_CLICK_ACTION', $meta_data = [], $image_url = null)
    {
        //NOTIFICATION OPTION BUILDER
        $option_builder = new OptionsBuilder();
        //decides how long should a notification stays in FCM storage is device is offline(in seconds)
        $option_builder->setTimeToLive(24 * 60 * 60); //24 hours

        //NOTIFICATION PAYLOAD BUILDER
        $notification_builder = new PayloadNotificationBuilder($title); //settings up title of notification
        $notification_builder->setBody($message) //settings up message of notification
            ->setClickAction($click_action) //setting up click action(used when someone clicks on notification)
            ->setSound('default'); //setting up the sound of notification(set to default)

        if ($image_url) {
            $notification_builder->setImage($image_url); //setting up the image if provided
        }

        //NOTIFICATION DATA BUILDER
        $meta_data_builder = new PayloadDataBuilder();
        $meta_data_builder->addData(
            [
                'data' => [
                    'title' => $title,
                    'body' => $message,
                    'click_action' => $click_action,
                    'meta_data' => $meta_data,
                ],
            ]
        );

        //finally building notification give all configuration
        $option = $option_builder->build();
        $notification = $notification_builder->build();
        $meta_data = $meta_data_builder->build();

        try {
            //checking if token array is not empty
            if (count($firebase_tokens) > 0) {
                //sending notification to all the tokens provided.
                $response = FCM::sendTo($firebase_tokens, $option, $notification, $meta_data);

                //checking if there is any Failure in sending notification
                if ($response->numberFailure() > 0) {
                    ErrorManager::registerError(__('messages.notification_failed_to_send', ['failure_number' => $response->numberFailure()]), __FILE__, '-', '-');
                }
            }
        } catch (\Throwable $th) {
            ErrorManager::registerError($th->getMessage(), __FILE__, $th->getLine(), $th->getFile());
        }
    }
}
