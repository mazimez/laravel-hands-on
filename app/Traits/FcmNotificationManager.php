<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait FcmNotificationManager
{

    /**
     * send notification to firebase tokens
     *
     * @param array $firebase_tokens - firebase tokens
     * @param string $title - title of the notification
     * @param string $message - message of the notification
     */
    static function sendNotification($firebase_tokens, $title, $message)
    {

        $option_builder = new OptionsBuilder();

        //decides how long should a notification stays in FCM storage is device is offline(in seconds)
        $option_builder->setTimeToLive(24 * 60 * 60); //24 hours

        $notification_builder = new PayloadNotificationBuilder($title); //settings up title of notification
        $notification_builder->setBody($message) //settings up message of notification
            ->setClickAction('TEST_CLICK_ACTION') //setting up click action(used when someone clicks on notification)
            ->setSound('default'); //setting up the sound of notification(set to default)


        //finally building notification give all configuration
        $option = $option_builder->build();
        $notification = $notification_builder->build();

        try {

            //checking if token array is not empty
            if (count($firebase_tokens) > 0) {

                //sending notification to all the tokens provided.
                $response = FCM::sendTo($firebase_tokens, $option, $notification);

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
