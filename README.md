# FCM notification and optimization

Welcome to the second installment of the FCM Notification implementation, accompanied by strategic code optimization. In our previous segment, we delved into the process of obtaining Firebase tokens for devices and subsequently dispatching notifications. In this continuation, our focus shifts towards storing these tokens, ensuring effective team collaboration, and enhancing system efficiency.
## Description

Building upon the foundation established in Part 1, where we explored fetching Firebase tokens and dispatching notifications, we now proceed to store these tokens for users. It's essential to acknowledge that a user can possess multiple Firebase tokens, representing different devices used for login. To facilitate this, a new JSON field, named `firebase_tokens`, will be added to the `users` table, ensuring unique token storage to prevent duplicate notifications.

As we embark on this journey, considerations include preventing token duplication on user logins, removing tokens upon user logout, and recording notification data in the database for user reference.

keep above points in mind, we also try to update our code in a way that a team of developer can easily work on it without having more problems like `merge conflicts` and files getting lost in merge. generally when working with team, project gets divided into different modules and each developer works on 1 module in separate branch. the problem arrives when 2 or more developer merge there branches to put the code into production.

while working separately in branch, a developer may add new `routes` in routes file and also new language keys into language file. but since all of our `routes` and `languages` are in 1 file, changes of different developers conflicts with each other while merging. to solve it, we can divide our `routes` and `languages` file into separate modules. this makes it easy for developer to add there changes without having conflicts with others since it stays in different files. so we will also do this in our project and divide our `routes` and `languages` file into multiple files based on modules like `users`, `posts`, `tags` etc.

## Files

1. [FcmNotificationManager](app/Traits/FcmNotificationManager.php): Enhanced trait now supporting image inclusion in notifications.
2. [2023_11_29_042719_add_firebase_tokens_field_to_users_table](database/migrations/2023_11_29_042719_add_firebase_tokens_field_to_users_table.php) and [2023_11_29_183155_create_notifications_table](database/migrations/2023_11_29_183155_create_notifications_table.php): New migrations managing notification-related data.
3. [Notification](app/Models/Notification.php): Notification model with a method for sending notifications based on type.
3. [NotificationController](app/Http/Controllers/Api/v1/NotificationController.php) and [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php): Controllers updated to handle notifications.
4. `removed some routes and language files`: Outdated route structures and language files replaced with a new structure.
5. `add new routes and languages`: Introduction of new route and language structures facilitating teamwork.
6. `updated controllers and other files`:  Codebase adjustments supporting the new `Routes` and `Languages` structure.

## Getting Started

1. first we will focus on `optimization`, so first we will go into [RouteServiceProvider](app/Providers/RouteServiceProvider.php) and update `mapApiV1Routes` and `mapApiV2Routes`. here, before we have just 1 file named like `v1.php` or `v2.php` but instead we will create a folder like `v1` and `v2` to store all the files version wise. In that folder we will have 1 `base.php` file that has normal `end-points`(routes) that's outside the modules. we also have files like `users.php`, `posts.php` that contains `end-points` according to that module. now we have to take our routes from `v1.php` and put them into different files based on which `module` they belongs to. I know this looks like some extra work that we don't need but not doing this will end up developers having merge conflicts, so if we can prevent that by doing some extra work then it's fine. it's important to check your APIs once the routes are updated, just to make sure it doesn't effect the APIs.

2. once our `routes` are done, we will do almost same for our languages file. we used to have `messages.php` file with all of our language keys in it, now we will divide that based on `modules` too. so we will have files like `post_messages.php`, `user_messages.php` etc. and we will transfer our languages keys there based on it's `module`. this also include more work since now we have to update all the places where we have used this keys, but we can easily do it just by searching specific keys into whole project with `vs-code` search. at the end it will make your life easier by preventing most of git conflicts. you should also test the APIs after this to make sure all keys are working.

3. now that our `optimization` is done, we can start with notification update. first we will add 2 new migrations [2023_11_29_042719_add_firebase_tokens_field_to_users_table](database/migrations/2023_11_29_042719_add_firebase_tokens_field_to_users_table.php) to add new json `column` named `firebase_tokens` that will store all the `firebase_tokens` of users. we also add [2023_11_29_183155_create_notifications_table](database/migrations/2023_11_29_183155_create_notifications_table.php) for the table to store all the info about user's notifications. it also has `morphing` so we can connect `notification` with any other resource like `user`, `post` etc.

4. now our migrations are ready, we will create a new model [Notification](app/Models/Notification.php) and update `User` model for `firebase_tokens`. in `notification` model, we will set some constants for our `click_action` and `type` of notifications. we will also add [NotificationSeeder](database/seeders/NotificationSeeder.php) to add some dummy notifications in system. also we will add some relationships on `Notification` model like `post` ,`user` and `notifiable`, same for `User` model and `Post` model as well. also we will add [NotificationController](app/Http/Controllers/Api/v1/NotificationController.php) to add the `end-point` for notification list so user can see all it's past notifications.

5. after setting up our models, we will go to our [UserController](app/Http/Controllers/Api/v1/UserController.php) and update our `login` and `socialLogin` method to take 1 new parameter with `firebase_token` and then we store it into `firebase_token` of `$user` variable. notice that we use methods like `collect`,`push` and `unique` to make sure no duplicates are getting stored. there are lot of other methods like that to help you handle arrays you can learn more about that from [Laravel doc](https://laravel.com/docs/10.x/collections#introduction). also I realize that we don't had a `logout` method at all. so we also add `logout` method that removes the `auth-token` and `firebase-token` as well. here frontend needs to provide the `firebase-token` of the device so we remove only the one that's getting logged-out. here we also use methods like `forget`, `search` that's also part of Laravel's `Collection`.

5. now that we can store the user's firebase-tokens. we will try to send notification now. we will first add 1 static method into [Notification](app/Models/Notification.php) model `sendNotification` that will use our `trait` to send notification. this method takes the instance of `Notification` model it self and send notification to it's connected user's `firebase_token` with all the data store on that instance like `title`, `message` etc. in the method you can see that we use `switch` case on `type` field of `notification` to send notification based on it's type. because some notification may need some extra step like adding image etc. so in future we can also add mode cases based on it's `type`.

6. you have probably noticed that we are passing the `image_url` when we are sending notification about `post_like`. this `image_url` will be used in [FcmNotificationManager](app/Traits/FcmNotificationManager.php) to add the image while sending notification. notification will look something like below with an Image.

<img src="https://i.ibb.co/0KjrRV3/notif-with-image.png" alt="notif-with-image" border="0">

7. now that our static method is ready, we will use it. for now we only send 1 notification when any post is liked, but in future we will use it for other type of events too. to send notification when post gets liked, we go to [PostLikeController](APP/Http/Controllers/Api/v1/PostLikeController.php) and update `toggle` method, this time we need to know when the post is getting liked and not just toggled. when post is getting liked, we will first create a new `Notification` and then use that to actually send notification to that post's owner. also notice that we wont send this notification if user like his/her own post.

8. To test this, you can use the firebase_token that you get from our web-page and then pass that token while login to store it in DB. then you have to login again from some other account and like some post of main account to get the notification. if for some reason it didn't send notification then you can check our log files to find the reason of it.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- In our notification `trait` as added the `image_url`, you can try to add more customization to that method to meet your need.
- as we divided our `routes` and `languages`, you can also do that for things likes `views`, `migrations` etc. this may requires more complex customization but will really help you when in bigger team.
- notice that we are focusing on only sending notification, we haven't think about what should happen when someone clicks on the notification. typically it's frontend application's JOB. so you can try to implement something in our web-page to handle when someone clicks on notification.

## Additional Notes

- keep in mind that the optimization we did with `routes` and `languages` is just a suggestions, it's your and your team's decision to arrange files that fits you best.
- till now we only send just 1 notification but in future we will use it more to send different notifications. also in later branches we will transfer all these notifications into queues to keep overall performance fast.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with the developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources
1. [Laravel code optimization tips](https://www.cloudways.com/blog/laravel-performance-optimization/)
2. [Improve Laravel performance](https://kinsta.com/blog/laravel-performance/)
