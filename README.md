# Error Handling

Efficient error handling is a critical aspect of any project. Some errors are straightforward to catch as they can disrupt the core functionality of the project. However, there are subtler errors that can be elusive, impacting the system indirectly and proving difficult to reproduce.

To effectively manage and document errors, Laravel provides a robust logging system that offers valuable insights into error occurrences.

## Description

In this section, we delve into potential errors that may arise within our system and explore the utilization of Laravel's logging system to meticulously record error details in a dedicated log file. It's important to note that not all errors can be immediately resolved. For instance, when sending emails, even if the email-sending code is technically correct, we cannot guarantee successful email delivery due to external factors such as proper configuration in the `.env` file and valid email details.

To address such production uncertainties, we rely on comprehensive error logging, with a particular focus on logging data into files.

## Files
1. [**logging**](config/logging.php): Revised configuration file to introduce the new 'errors' channel for error logging.
2. [**ErrorManager**](app/Traits/ErrorManager.php): Added a new trait to facilitate error logging management.
3. [**PostCreatedListener**](app/Listeners/PostCreatedListener.php) and [**PostDeletedListener**](app/Listeners/PostDeletedListener.php): Updated listeners to integrate the error logging system.
4. [**UserObserver**](app/Observers/UserObserver.php): Enhanced observer to incorporate error logging functionality.

## Instructions

Follow these steps to seamlessly implement the changes and maximize the utility of available resources:

1. Begin by examining the [**logging**](config/logging.php) configuration file to gain insights into Laravel's logging mechanism. Pay close attention to the `channels` array, which lists all available channels for data logging. These channels can be employed to log data into files or transmit it to external systems like Slack or Papertrail. Refer to the [Laravel documentation](https://laravel.com/docs/10.x/logging#available-channel-drivers) for further details.

2. Introduce a new channel named 'errors' in the configuration file. Configure this channel with the 'single' driver, indicating that it will log data into a single log file over time. Specify the log file's path and the minimum log level (e.g., 'error') to determine which types of messages are logged. Refer to Laravel's [log levels](https://laravel.com/docs/10.x/logging#log-levels) for additional information.

3. Create a new trait, [ErrorManager](app/Traits/ErrorManager.php), to facilitate error logging within the system. This trait should contain a method, 'registerError,' which accepts error-related information as parameters and logs it to the error log file. Customize the parameters to capture essential error details, such as the error message, invoking file path, error line number, and file path where the error occurs.

4. When adding error logs to the log file, ensure that the log message is well-formatted with appropriate line breaks (using `PHP_EOL`). Utilize the `Log::channel` method, specifying the 'errors' channel to log data to the [error-logs](storage/logs/error-logs.log) file, and use the 'error' method to mark it as an error. Laravel offers other methods, such as 'emergency,' 'alert,' and 'critical,' for selecting log levels; consult the [Laravel documentation](https://laravel.com/docs/10.x/logging#writing-log-messages) for details.

5. Apply the ErrorManager trait to listeners, observers, or any relevant parts of your codebase where error logging is necessary. For example, refer to [PostCreatedListener](app/Listeners/PostCreatedListener.php). When sending emails, encapsulate the code within a 'try...catch' block and invoke the 'registerError' method to log error information. Utilize 'getLine' and 'getFile' methods on 'Throwable $th' to retrieve precise line numbers and file paths, along with '__FILE__' to obtain the current file's path. Repeat this process in other relevant files, such as [UserObserver](app/Observers/UserObserver.php) and [PostDeletedListener](app/Listeners/PostDeletedListener.php).

6. To test the error logging functionality, intentionally modify the email credentials in the `.env` file. This alteration will trigger an error within Laravel, and the error details will be logged in the [error-logs](storage/logs/error-logs.log) file.

7. With proper configuration, your APIs, such as 'create user' or 'create post,' will continue to provide normal responses to end-users while discreetly logging any encountered errors. This error-handling approach can be extended beyond email errors to address various types of issues within your system.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- there are many customization you can do with [logging](config/logging.php) config and log system in general. for example, there can be some errors that are very crucial to you and you want to get notified on the stop when that error happen, you can do that with Laravel-logging and directly send mail about that error or maybe send message on `slack` too. try to implement this kind of error handling system.
- while storing error on a file inside your Laravel project, there will come a time when you error file gets larger in file size. most of it's data is not needed so you can simply remove content from it in you local machine but when you put this on some sever(in production), you need to make sure to either check and clear this file periodically or put some kind of automatic system for it. in later branches we will learn about `scheduler-cron` that can help you with this. try to learn about it and implement it.

## Note

- In future branches, we will explore integrating logging with tools like Slack. This branch primarily focuses on acquainting you with Laravel's logging capabilities and their utilization for error storage.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation for Logging](https://laravel.com/docs/10.x/logging#introduction)
2. [How Logging Works in Laravel Applications](https://www.freecodecamp.org/news/laravel-logging/)
