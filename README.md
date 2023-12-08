# Jobs and Queues

The concept of queues, previously discussed in the [events-listeners-queue](https://github.com/mazimez/laravel-hands-on/tree/events-listners-queue) branch, is revisited here to delve into running jobs in the background. A queue allows us to efficiently handle tasks asynchronously by adding them to a list (queue) and executing them sequentially in the background. These tasks are typically ones that either consume significant time or have no immediate impact on the system. Queues can be stored in the system's database or external services like [AWS SQS](https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/welcome.html).

## Description

In our system, we utilize the database to store queue data. Initially, we focus on queuing notification-sending tasks and subsequently plan to extend this to handling emails. Laravel provides Jobs as representations of tasks in the queue. Jobs can cover a broad spectrum of activities, including sending notifications or emails, generating PDFs or Excel files, and making API calls. It's crucial to refrain from queuing tasks that require immediate execution.

Laravel supports different queue handling methods, such as using the database, Redis, or SQS. In this instance, we opt for the database. Laravel also offers features like handling failed jobs, making jobs unique, and batching jobs. This section provides a fundamental introduction to Jobs.

Introducing a new badge, "first like," is incorporated into the queue implementation. Additionally, users will now receive notifications when they achieve a new badge.

## Files

1. [SendNotificationJob](app/Jobs/SendNotificationJob.php): A new job created to send notifications via the queue.
2. [PostObserver](app/Observers/PostObserver.php), [UserBadgeObserver](app/Observers/UserBadgeObserver.php), and [PostCommentObserver](app/Observers/PostCommentObserver.php): Observers updated to handle notifications and badges.
3. [EventServiceProvider](app/Providers/EventServiceProvider.php), [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php): Providers updated to manage observers and store job data in Telescope.
4. [BadgeSeeder](database/seeders/BadgeSeeder.php): Seeder updated to add the new badge.


## Getting Started

1. we will update our [BadgeSeeder](database/seeders/BadgeSeeder.php) and add new badge for `first like` so we can then use it. then we will make sure our Queue is set-up properly. so first open [queue](config/queue.php), see that there is a key of `connections` that has an array of different type of queues. we can select our queue by `QUEUE_CONNECTION` environment variable and it's value will be `database` indicating that it's using database to store all the info about Queue & Jobs. you can try other service too, but for start we will go with simple `database` and as we discussed in [events-Listeners-queue](https://github.com/mazimez/laravel-hands-on/tree/events-listners-queue) and [deployment](https://github.com/mazimez/laravel-hands-on/tree/deployment) branches that queue needs to be running in background either with `php artisan queue:work` command or with some other way on your server. once you have make sure that your queue is running we can focus on putting some Task(JOB) in it. also make sure you have `jobs` table in your DB, if not then just run `php artisan queue:table` and `php artisan migrate` to add it.

2. we will create a `JOB` to send notification with the command `php artisan SendNotificationJob`. this will create a new file [SendNotificationJob](app/Jobs/SendNotificationJob.php). In this file, we take `$notification` instance in our constructor and in `handle` method we simply use that to send actual notification to user. we already have our `Trait` and other methods to send notification so this will just be a 1 line code here. that's it for creating a `JOB`, now we have to put this JOB into queue with proper notification whenever we want to send a notification. each `JOB` can be put into `queue` with `dispatch` method.

3. currently we are only sending notification when someone like the post of some user. so in the [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php), in `toggle` method we will replace our notification sending code with `dispatch` method with `SendNotificationJob` and pass the new `$notification` that we created. this will put the JOB onto queue(you can also see that in your `jobs` table). If your queue if running then it will automatically pick up this JOB and execute it, sending notification to the User. any other kind of `jobs` will follow the same flow where you first define the JOB and it's tasks the put it into `queue` to run it 1 by 1. you maybe thinking why we set-up whole queue just to send 1 notification, this queue will help us sending all other notifications that we are about to add.

4. before adding any new notification, we will update our [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php) further and add the LOGIC to add new badge on the user when it's post is liked for the first time. once that logic is added, we can focus on sending notification for each new badge we add for user. we will add new observer [UserBadgeObserver](app/Observers/UserBadgeObserver.php) that can give us a common place to put our notification code so it will send notifications whenever new Badge gets added. here we will simply create a new notification and put it's JOB into queue. now whenever any new Badge is given to some user, that user gets a notification.

5. with more and more badges and users, this notification sending process gets bulky and can make our system slow. that's why putting all notifications into queue gives us option to keep our system fast and still send Tons of notifications. it is possible that this notification gets delayed but it's fine since we don't need it to be instantaneous. we can do this same things for other process like `Sending emails` and Generating some `PDF reports`, we will implement those features in future branches too.

6. It is also possible that while executing any JOB, it fails. these failed `JOBs` goes into `failed_jobs` table where you can look into the reason of their failure and also RUN that JOB again. if you don't have `failed_jobs` table then you can create it with `php artisan queue:failed-table` (see more about it from [Laravel-doc](https://laravel.com/docs/10.x/queues#dealing-with-failed-jobs)). for testing it, you can produce a case where JOb failed. first stop your queue and then send some notification(for badge or like), this will add new JOB into queue. now before starting your queue, delete that new notification from database. now when you start your queue it will try to find that notification but it wont be there, thus it will throw and exception and put it into `failed_jobs`.

7. Laravel provides couple of commands with which you can see all the failed JOB and RUN them again as well. generally whenever this kind of Background process failed, we should have some system that inform us(developers) via `Mail` or `some message` since this error may not get noticed by anyone. we will prepare a flow where we can receive Alerts whenever any process fails, for now you can refer to [Laravel doc](https://laravel.com/docs/10.x/queues#retrying-failed-jobs) to handle these failed JOBs.

- so this was the basic of JOBs & Queues, there are still many things we need to cover about JOBs that will look into in future branches.


## DIY (Do It Yourself)

Explore additional tasks:

- Implement more jobs for handling email notifications.
- Learn about and implement unique job handling as described in the [Laravel documentation](https://laravel.com/docs/10.x/queues#unique-jobs).

## Additional Notes

- Only queue tasks that either take a considerable amount of time or have no immediate impact on the system. Critical tasks requiring immediate attention should not be queued.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with the developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel documentation on Queues](https://laravel.com/docs/10.x/queues#introduction)
2. [Queue tutorial](https://bagisto.com/en/how-to-use-queue-and-job-in-laravel-10/)
