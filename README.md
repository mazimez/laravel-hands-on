# Observers

Observer functionality in Laravel provides an event-driven approach for managing various actions performed on resources. These actions encompass creation, updating, and deletion events. By utilizing observers, developers can efficiently implement tasks like sending notifications, handling file removals, and maintaining activity logs.

## Description

In the context of this guide, we'll explore observers in two specific scenarios: removing associated files upon database entry deletion and sending welcome emails upon user registration.

## Files

This section outlines the relevant files associated with the changes explained in this guide:

1. [v1](routes/api/v1.php): Introduces new routes for user registration and updates.
2. [PostController](app/Http/Controllers/Api/v1/PostController.php), [UserController](app/Http/Controllers/Api/v1/UserController.php), and other controllers: Updated to support new APIs and observers.
3. [FileObserver](app/Observers/FileObserver.php), [UserObserver](app/Observers/UserObserver.php), and other observers: Added to listen to various events.
4. [EventServiceProvider](app/Providers/EventServiceProvider.php): Updated to associate the observer with the model.
5. [welcome_mail.blade](resources/views/welcome.blade.php): Includes a sample blade file for a welcome email template.

## Instructions

Follow these step-by-step instructions to effectively implement the changes and maximize the potential of the available resources:

1. **Understanding Observers**: Observers are distinct classes containing methods (events) triggered upon changes to associated models. To create an observer, use the command `php artisan make:observer UserObserver --model=User`. This generates a `UserObserver` class with default methods like `created` and `updated`, serving as listeners for actions involving the [User](app/Models/User.php) model.

2. **Binding Observers to Models**: Simply creating an observer doesn't automatically trigger its listener methods. To link an observer to a model, navigate to the `boot` method in the [EventServiceProvider](app/Providers/EventServiceProvider.php). Utilize the `observe` method on the relevant model and pass the observer class (`UserObserver`) as an argument. This establishes the connection, enabling the listener methods upon model updates.

3. **Sending Email Notifications**: To send a welcome email to newly registered users, create a dedicated API route (`user/register`). Add this route in the [v1](routes/api/v1.php) file and connect it to the `store` method of the [UserController](app/Http/Controllers/Api/v1/UserController.php). Within this method, use the [User](app/Models/User.php) model to create users while validating incoming request data.

4. **Observer Usage**: When the `create` method is invoked on the [User](app/Models/User.php) model, adding a new user to the database, the `created` method within the [UserObserver](app/Observers/UserObserver.php) becomes active. This method triggers the sending of a welcome email to the registered user's email address. Centralizing email dispatch within the observer ensures a consistent approach across the application.

5. **Observer's Flexibility**: The true power of observers is evident when considering scenarios beyond direct controller-based user creation. By employing observers, you establish a reliable mechanism for sending email notifications, even if users are created via different methods or multiple APIs.

6. **Managing File Deletion**: The [FileObserver](app/Observers/FileObserver.php) introduces enhanced functionality by addressing file deletion scenarios. The `deleted` method within this observer is triggered when a record is deleted from the database. It ensures associated files are also deleted from storage, maintaining synchronization between database entries and actual files.

7. **Data Integrity Considerations**: Within the `FileManager` class, the `deleteFile` method is modified to prevent the accidental deletion of default files added by seeders. This ensures that only non-seeder-added files are deleted.

8. **Enhancing File Deletion**: Notably, file deletion events aren't automatically triggered when deleting files within the `update` method of the [PostController](app/Http/Controllers/Api/v1/PostController.php). To overcome this, utilize the `destroy` method on the `File` model. Provide the IDs of the files to be deleted. This approach initiates delete events, effectively removing the corresponding files from storage.

9. **Refining File Deletion for Posts**: To further enhance file management, a [PostObserver](app/Observers/PostObserver.php) is introduced. This observer ensures that associated files are deleted whenever a post is removed.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- there may come a time when you don't want observer to perform any action when new resource gets `created/updated` etc. mainly in seeder since that data is just dummy data and we don't want to send mails when any dummy user gets created. you can find a way to somehow stop observer from observing(we will see it in next branch)
- observer can sometime creates very interesting scenarios like if you create and observer for some resource and on the `created` method you create another resource of that same class then it can end up in an infinite loop. try to create this situation and see how you can overcome it.

## Note

- Engage in comprehensive discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation for Observers](https://laravel.com/docs/10.x/eloquent#observers)
2. [Observer Tutorial](https://www.itsolutionstuff.com/post/laravel-8-model-observers-tutorial-exampleexample.html)
