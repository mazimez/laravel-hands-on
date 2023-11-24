# FCM notification

Notifications serve as a crucial means of direct communication between our system and users, delivering important messages through various channels such as email, device notifications, and more. These notifications play a pivotal role in keeping users informed about significant events within our system, such as post interactions, new followers, or alerts related to their accounts.

## Description

in out system, we already have Email notifications, so this time we focus on sending device notification that comes up in attention directly when opening any device. there are many services that help us implementing this notifications, the most common one is `firebase`. the `Firebase Cloud Messaging` is a service that lets you send notifications to different devices and we are going to use to send notifications to user's device. now, if our user is using our system as a WEB application then we will send notification to the browser and that browser will show it to user. if customer is using it as `android/IOS` app on his/her device then we can directly send it to That APP and it will show it to user.

now before we understand how to send this notification, we first need to create our account with `firebase` so it can help us sending the notifications. now go to firebase's website and create your account, after that go to `firebase console` and there you get the option to create your project, something like shown below
<img src="https://i.ibb.co/KNnzv0F/CREATE-PROJECT.png" alt="CREATE-PROJECT" border="0">

once you click on `create a project` it will ask you some basic info about your project's name, country of origin etc. after filling all that details, it will create a new project for you. it will look something like below, you will have different options like IOS, ANDROID and WEB etc.
<img src="https://i.ibb.co/cDcG5qp/CONNECT-APP.png" alt="CONNECT-APP" border="0">

we will select WEB for now, it will take you to a form where you have to enter your project name, then it will give you firebase-SDK code that you can use in your project(something like shown below), so copy that code and keep it somewhere safe(you can still get it again from project's settings)
<img src="https://i.ibb.co/qnZVtn2/SDK-CODE.png" alt="SDK-CODE" border="0">

now that our project is ready, we will first configure it so it can send notifications. for that go to project settings, it will be at the top left side of the panel(something like shown below)

<img src="https://i.ibb.co/RgCLnMg/PROJECT-SETTINGS.png" alt="PROJECT-SETTINGS" border="0">

in the setting section, go to cloud messaging, there you will see that `Cloud Messaging API (Legacy)` is disabled, so we need to enable it. so click on that 3 dots and open the google cloud console. there you will see a button to enable that API, click on it.
<img src="https://i.ibb.co/rxZrNCX/CLOUD-MESSAGING.png" alt="CLOUD-MESSAGING" border="0">

 once it's done go back to console and refresh there you will now see that it's enabled.

 <img src="https://i.ibb.co/r6VKc65/API-ENABLED.png" alt="API-ENABLED" border="0">

we need to take 2 things from here `Server key` and `Sender ID` since this will be used by our project to actually send notifications to users. so copy those and save it. now our work with firebase console is done. so we go back to our project and first we install a new package that will allow us to send notifications to users. there are many packages to implement this FCM notification in Laravel. we will use `code-lts/laravel-fcm` in our case. you can use any other package you want but follow it's documentation since it can be different then ours.

```
composer require code-lts/laravel-fcm
```

run the above command to install the package, then go to `.env` file and add 2 new variables `FCM_SERVER_KEY` and `FCM_SENDER_ID` and we will set it's value to the ones we get from firebase console. there are still some more variables that we need to add but we will add it later. after setting up `.env` file, we are ready to send the notifications.

## Files

1. [FcmNotificationManager](app/Traits/FcmNotificationManager.php): added new trait for FCM notifications.
2. [services](config/services.php): updated services config file to add firebase service
3. [TestController](app/Http/Controllers/Api/v1/TestController.php): new method added to send notification.
4. [firebase-messaging-sw](public/firebase-messaging-sw.js) and [home.blade](resources/views/auth/home.blade.php): added some `js` for notifications.
5. [composer.json](composer.json) and [composer.lock](composer.lock): added new package for FCM notification.
6. [v1](routes/api/v1.php): New routes added for testing notification.

## Getting Started

1. now we will go to [services](config/services.php) config file and add new service as `firebase`. there we will add all new keys that we will be needing for our implementation. value for all these keys comes from `.env` file. you can get the values for all these variables from that `SDK-CODE` we get while creating project. so take all those values and set it as environment variables. now that our `.env` and `config` is ready, we will create a new Trait [FcmNotificationManager](app/Traits/FcmNotificationManager.php) and in that we create a new method `sendNotification` that we will use to send notifications.

2. now to send notification to any User(Device), we need that device's ID. firebase assign each device a unique ID(called `Firebase Token`) that we can refer to send that device notifications. so in our trait's method we will take an array of those `firebase tokens` and send notifications to those tokens, it also take `title` and `message` for that notification. you can see the code for sending the notification where first we use `OptionsBuilder` from our package to configure some options like how long will the notification stays if user's device is OFFLINE. then we use `PayloadNotificationBuilder` to configure notification's data like it's `title` `message` and `Click Action` etc. we will discuss about this in detail in out future branch. you can also refer to it's [documentation](https://github.com/code-lts/Laravel-FCM) for more info

3. once the notification is configured, we build the notification and use `sendTo` method to actually send this notification to given `firebase tokens`. after that we also check if there is any Failure in sending those notifications. is there is then we put it logs into error-logs file so we can refer to it later. so now our trait to send notification is ready. we will create a new test-route `send-notification` to use this trait and send notification to given firebase-token.

4. now our route is ready, to test this we still need to get the `firebase-token` of our device so we can actually send notification to it. for that we need to update our web. remember that web-login system we build in previous branch, we will use that here. but before that we need to create 1 `js` file in our public folder. [firebase-messaging-sw](public/firebase-messaging-sw.js) file is created to register a `service-worker` in our browser. the `service-worker` is simply a process that keeps running in background even if browser is closed. so we use this `service-worker` to keep checking for any new notification. you can try to understand the code on that `service-worker` but it if doesn't make sense then it's fine since our current focus is on `sending` the notifications rather then `receiving` or `managing` it.

5. once our `service-worker` is set, we will go to [home.blade](resources/views/auth/home.blade.php) file and add some `JS` to get the `firebase-token` of our device. first we will add new `p` tag to print our firebase-token and in `js` we will use all those keys from config to connect to our firebase project and fetch `firebase-token`. you also don't need to understand the `js` code, just keep in mind that it's used to fetch the `firebase-token`.

6. after this code is added, if you login into our web-page you will probably ask for `notification permission`. it look something like shown below. you have to allow it so browser can show notifications. once you allow it, your should see your device's `firebase TOKEN` on web page(something like shown below). now we can use this `firebase-token` to actually send notification to our device.

<img src="https://i.ibb.co/Kmc2tRX/permissiong.png" alt="permissiong" border="0">
<img src="https://i.ibb.co/NxqHQXL/firebase-token.png" alt="firebase-token" border="0">

7. copy that `firebase-token` and send it to our `test-api` with `title` and `message` for notification. if everything is set-up correctly you should receive a notification(something like shown below).

<img src="https://i.ibb.co/9TXSmvs/notification.png" alt="notification" border="0">

8. so that's how you can send notification to any device(if you have it's firebase-token). you can try to run this project in some other device and get it's firebase-token and send notification to it from another device too. the process may look a little lengthy but notifications will really help keeping customer updated.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to run project in another device and send notification from 1 device to another.
- try to understand the `js` code and make some updates in it to according to your need.
- try to update the notification trait to allow some more customization on things like `click action`, `sound` etc.

## Additional Notes

- In upcoming branches, we use our notification trait to send notification to users about updates in our system.
- keep in mind that as a backend system, it's not our job to fetch firebase-token. firebase-token is fetched from frontend application and our backend stores it and only send notifications on it. then it's frontend's job to properly show that notification. so keep your focus on storing the firebase-tokens and sending notification on it, rather then showing that notification on different devices.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with the developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources
1. [Laravel FCM package](https://github.com/code-lts/Laravel-FCM)
2. [FCM push notification tutorial](https://medium.com/geekculture/laravel-tutorial-push-notification-with-firebase-laravel-9-3095058c2155)
