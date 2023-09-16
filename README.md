# Scheduler-Cron jobs

Cron Jobs is feature provided in Unix-like operating systems. it provides a way to perform some task repeatedly open some period of time. that time period can be 1 day, 1 week, 1 month even 1 year. and this process happens in background on it's one, it doesn't need to be under any observation to get executed.

Laravel provides a Good way to manage this process easily called "Scheduler", and it even supports other OSs like Windows too.

## Description

In this section, we will implement 1 background process that will run monthly and it will send mail to a User who added the most posts in system that month, thanking User and showing him/her our appreciation.(in future we will implement some `badges` system that user will earn for doing thing like this)

## Files
1. [**CalculateMonthlyRewards**](app/Console/Commands/CalculateMonthlyRewards.php): added a Command to calculate monthly rewards for users.
2. [**Kernel**](app/Console/Kernel.php): updated the kernel file to use the command every month.
3. [**MostPostedMail**](app/Mail/MostPostedMail.php): added new mail for most posted mail.

## Instructions

Follow these steps to seamlessly implement the changes and maximize the utility of available resources:

1. before setting up the Scheduler, we first prepare 1 `Mail` to send to user with most added post on the month. we create [**MostPostedMail**](app/Mail/MostPostedMail.php) that will take `User $user` and count of posts that the User has added at any particular month. we also make 1 new blade file [most_posted](resources/views/most_posted.blade.php) that will be used as template for mail.

2. now that `Mail` is ready, we can start with Scheduler. generally there are lots of ways to Schedule any Process, we will focus on doing it with `Artisan Command`. the `Artisan` is the command line interface used in Laravel that can help you to create your own `commands` that you can use repeatedly. you can learn more about it from [Laravel doc](https://laravel.com/docs/10.x/artisan#writing-commands).

3. now to create an artisan command, use the command `php artisan make:command CalculateMonthlyRewards`, this will create a new file [CalculateMonthlyRewards](app/Console/Commands/CalculateMonthlyRewards.php). you can see that this file has 1 variable called `$signature` that we can use to define our command. this can then we used in command panel to call this file's `handle` method.

4. in the handle method, we will put all of our code that we want to run when the command is executed. so in `handle` method we put our logic to first get the user with most post added for current month and then send that user an Email to show our appreciation. to test this, you can just run this command like `php artisan calculate:rewards:monthly`, this should send the mail to the user who added most posts this month.(you probably need to find the user with most posts and then change it's mail to an Actual mail so you can receive the mail)

5. now that our Command is working, we have to make it that this command runs every month on it's own so it sends mail every month. for that go to [Kernel](app/Console/Kernel.php) and go into `schedule` method, there we will use `$schedule` variable and call `command` method that will actually runs any `artisan` command give in parameter. we will pass `calculate:rewards:monthly` in it. after that `command` method we will decide the frequency of repetition by calling method `monthly`, this will run the command every month. you can learn more about it from [Laravel doc](https://laravel.com/docs/10.x/scheduling#schedule-frequency-options).

6. so after setting up the [Kernel](app/Console/Kernel.php), Laravel still wont run the command on it's own. we need to run 1 command `php artisan schedule:run` for Laravel to be able to run the command. there is also a command `php artisan schedule:work` for Laravel to keep active and run any command that comes next(almost like `php artisan serve` to serve the project). you can also run command like `php artisan schedule:list` to get the list of all the commands with info like when it's going to get run.

7. you may be thinking that now you always need to keep that `php artisan schedule:work` active in order to scheduler to work, and that can not be possible when we put our project into Production on any Server. well that' where Cron-JOB comes in play. Cron-job will allow us to run this kind of commands in background without us having to keep the command running manually.

8. Cron-jobs are specific to Ubuntu/Linux OS, so we can not use it if we are on Windows and process of Setting up the cron job is little completed and hard to explain in this branch since we already cover scheduler. so we will discuss this in another branch that will focus on Deploying your Laravel projects.
## Note

- In future branches, we will see how we can use the scheduler even without `Artisan Command`.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation for Artisan Command](https://laravel.com/docs/10.x/artisan#introduction)
2. [Laravel Cron Jobs Scheduling To Make Automation Easier](https://www.cloudways.com/blog/laravel-cron-job-scheduling/)

