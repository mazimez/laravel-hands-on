# Event Listeners and Queues

Event Listeners and Queues are two closely intertwined topics within Laravel development. While they serve distinct purposes, they are often used in conjunction to enhance the efficiency and responsiveness of applications. In this guide, we will explore both subjects comprehensively.

## Introduction

**Event Listeners** in Laravel provide a mechanism to respond to events triggered within the application. These events could be anything from "Post Created" to "User Followed." Listeners "listen" for these events and execute predefined actions in response. On the other hand, **Queues** are a general concept where tasks are placed in a queue and executed sequentially. Laravel leverages Queues to handle time-consuming operations such as sending emails, generating PDFs, or processing data in the background.

## Description

In this guide, we will introduce two new features to illustrate the power of Event Listeners and Queues in Laravel:

1. **Post Deletion with Reason Notification**: When an admin deletes a post, they are now required to provide a reason. This action triggers an email notification to the post owner, explaining the deletion rationale.

2. **Promoting New Posts**: Whenever a new post is created, and the post owner has fewer than 50 followers, the application sends an email notification to 10 randomly selected users. This encourages engagement and helps the post owner gain more followers.

While these features could be implemented using observers, leveraging Event Listeners and Queues ensures that users don't experience delays during these processes.

## Files
1. [**PostCreatedEvent**](app/Events/PostCreatedEvent.php) and [**PostDeletedEvent**](app/Events/PostDeletedEvent.php): These events handle post-related actions.
2. [**PostCreatedListener**](app/Listeners/PostCreatedListener.php) and [**PostDeletedListener**](app/Listeners/PostDeletedListener.php): Listeners that respond to the events.
3. [**PostCreatedMail**](app/Mail/PostCreatedMail.php) and [**PostDeletedMail**](app/Mail/PostDeletedMail.php): Email notifications for post management.
4. [**PostController**](app/Http/Controllers/Api/v1/PostController.php): Controllers updated to trigger the events.
5. [**post_created.blade**](resources/views/post_created.blade.php) and [**post_deleted.blade**](resources/views/post_deleted.blade.php): Sample blade files for new email notifications.
6. [**2023_09_02_071731_create_jobs_table**](database/migrations/2023_09_02_071731_create_jobs_table.php): Migration for setting up the queue.
7. [**PostSeeder**](database/seeders/PostSeeder.php) and [**UserSeeder**](database/seeders/UserSeeder.php): Seeders updated to add data without triggering events.
8. [**EventServiceProvider**](app/Providers/EventServiceProvider.php): Configuration for event auto-discovery.
9. [**.env.example**](.env.example): Example .env file updated to configure the queue to run on the database.
10. `Removed`: **PostFilePolicy** removed since it's not needed anymore.
## Instructions

Follow these step-by-step instructions to effectively implement the changes and maximize the potential of the available resources:

1. **Optimizing Seeders**: Before proceeding with the new implementations, let's address an issue with seeders. After adding observers, seeders might take longer to execute due to the automatic sending of welcome emails to new users. To resolve this, Laravel provides methods like `createQuietly` and `withoutEvents` that prevent event triggering during data seeding.
so we use this methods in our seeder to make sure no unnecessary observer are used while seeding. Learn more about these methods in the [Laravel documentation](https://laravel.com/docs/10.x/eloquent-relationships#the-create-method).

2. **Creating Events**: With the seeders optimized, let's create a new event for post deletions by admins. Use the command `php artisan make:event PostDeletedEvent` to generate the [PostDeletedEvent](app/Events/PostDeletedEvent.php) class. This event's constructor accepts essential data such as post title, deletion reason, and the post owner's email. notice that we could have just take the whole post model but we didn't since the post may have already been deleted, so it's better to directly take the data that we need.

3. **Creating Listeners**: Every event should have at least one listener. Generate a listener for our event using the command `php artisan make:listener PostDeletedListener --event=PostDeletedEvent`. The [PostDeletedListener](app/Listeners/PostDeletedListener.php) class is created, and it will be triggered whenever the [PostDeletedEvent](app/Events/PostDeletedEvent.php) occurs. In the `handle` method of the listener, we send an email to the post owner with the deletion reason. Explore the [mails branch](https://github.com/mazimez/laravel-hands-on/tree/sending-mails) for more information on handling emails.

4. **Events Auto Discovery**: Laravel 10 simplifies event and listener registration through auto-discovery. In [EventServiceProvider](app/Providers/EventServiceProvider.php), set `shouldDiscoverEvents` to `true`. This enables Laravel to automatically register all events in the event folder. Find more details in the [Laravel documentation](https://laravel.com/docs/10.x/events#event-discovery).

5. **Triggering Events**: Now that our event and listener are ready, let's call them from [PostController](app/Http/Controllers/Api/v1/PostController.php) in the `destroy` method. First, check if the logged-in user is an admin and if the request includes a "reason" parameter. If conditions are met, use the `dispatch` method with `PostDeletedEvent` to pass the required information to the event's constructor. This action triggers an email to the post owner. To test this, create a user with a valid email, delete one of their posts, and observe the email notification.

6. **Configuring and Using Queues**: To implement the feature of sending emails to 10 random users when a new post is created, we need to enable and configure the Queue. In the [.env](.env) file, update the `QUEUE_CONNECTION` variable to "database." This instructs Laravel to use the database for Queue management. Run `php artisan queue:table` to generate a migration, [2023_09_02_071731_create_jobs_table](database/migrations/2023_09_02_071731_create_jobs_table.php), for the queue. Execute the migration with `php artisan migrate` to create the "jobs" table.

7. **Using Events and Listeners with Queue**: Create a new event, [PostCreatedEvent](app/Events/PostCreatedEvent.php), and a listener, [PostCreatedListener](app/Listeners/PostCreatedListener.php), for sending emails to 10 random users when a new post is created. Notably, the listener implements the `ShouldQueue` interface, indicating that it should be stored in the queue for asynchronous execution. In [PostController](app/Http/Controllers/Api/v1/PostController.php), in the `store` method, check if the post owner has fewer than 50 followers. If true, dispatch the `PostCreatedEvent`.

8. **Running the Queue**: With everything set up, new tasks will be added to the "jobs" table when a post is created. To execute these tasks, run the command `php artisan queue:work`. This command processes tasks in the queue one by one, removing them from the "jobs" table upon completion. This ensures that email notifications are sent efficiently in the background without affecting the user experience.

9. **Benefits of Using Queue**: It's important to note that Queue offers significant benefits, particularly in scenarios where time-consuming operations can hinder the responsiveness of an applicationif you try removing that `ShouldQueue` interface from `listener` that will execute it without `queue`, but then you will see that after this will take significantly more time while using `create post` API, that's because all mails are being sent right when you call the API and that's making it slow.
By using Queue, these operations are seamlessly executed in the background, enhancing overall performance.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to find more places where you can use this queue concept.
- we haven't talk about `jobs & queue` yet but we will do it in future branches, till then you can try to research about it on your own.
- here we only use queue with the Database, but there are lots of other ways to handle queue as well(like `AWS`). try to implement other ways as well.
## Note

- `Queues` has a lot more use cases that we will cover in future branches. this was an Introduction to `Queue` and how we can use it with `Event` and `Listeners`. remember to not over use `Event-Listener` and also `Observer`, those features should only be used when it's really improving System's Speed and Stability.
- Engage in comprehensive discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation for Events](https://laravel.com/docs/10.x/events#main-content)
1. [Laravel Documentation for Queues](https://laravel.com/docs/10.x/queues#main-content)
2. [Event Listener with Queue](https://ahmedshaltout.com/laravel/laravel-events-listeners-with-queue-tutorial/)
