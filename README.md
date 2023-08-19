# Sending Mails

Mails are a crucial communication channel for any project or product, enabling effective interaction with customers. Laravel offers robust functionalities for managing email processes.

## Description

This guide illustrates the creation of a new API in Laravel for sending emails. We'll explore sending emails with attachments and how to set the email's language as per your requirements.

## Files

The following files capture the changes and additions in this branch:

1. [.env.example](.env.example): updated the `.env` example file to show the sample for mail configuration.
2. [TestController](app/Http/Controllers/Api/v1/TestController.php): The controller is updated to incorporate the `sendMail` method.
3. [v1](routes/api/v1.php): New routes are introduced for sending emails.
4. [SampleMail](app/Mail/SampleMail.php): A mail class is implemented to send sample emails from the controller.
5. [test_mail.blade](resources/views/test_mail.blade.php): A sample mail template blade file is added.
6. `REMOVED`: The migration, model, and factory for `post_files` are removed.

## Instructions

Please follow these step-by-step instructions to implement the changes effectively and make the most of the available resources:

1. **Email Setup**: Configure a mail account to enable email sending. We'll focus on Gmail as an example. You can either create a new Gmail account or use an existing one.

2. **Two-Step Verification**: To send emails through third-party applications like Laravel, activate two-step verification for your Gmail account. Generate an application-specific password specifically for your Laravel application. For more details, refer to [this article](https://www.grepper.com/writeups/laravel-mails-google-security-updates-707b6a7e0b57f4).

3. **.env Configuration**: Update your `.env` file with your Gmail account credentials. Pay attention to variables such as `MAIL_MAILER`, `MAIL_USERNAME`, and `MAIL_FROM_NAME`. Update `MAIL_USERNAME` and `MAIL_PASSWORD` with your Gmail credentials. Other variables like `MAIL_HOST` and `MAIL_PORT` can remain unchanged. These settings configure the SMTP mailer.

4. **Configuration**: Examine the [mail](config/mail.php) configuration file. The `mailers` section contains various drivers like `smtp`, `ses`, and `mailgun`. As our `MAIL_MAILER` is set to `smtp`, the driver is configured accordingly. Configure the sender's name and address in the `from` section. For more details, refer to the [Laravel documentation](https://laravel.com/docs/10.x/mail#configuration).

5. **Creating a Mailable**: Use the `php artisan make:mail SampleMail` command to create a [SampleMail](app/Mail/SampleMail.php) file. This class will define the email's content, attachments, and other details.

6. **SampleMail Class**: In the [SampleMail](app/Mail/SampleMail.php) class, declare public variables to store content and files. Retrieve this data in the constructor. Use the `envelope` method to set the email's subject and sender's name. Attach files in the `attachments` method as an array. Refer to the [Laravel documentation](https://laravel.com/docs/10.x/mail#attachments) for more on attachments.

7. **Mail Template**: Create [test_mail.blade](resources/views/test_mail.blade.php) to serve as a mail template. Include two lines: one from the [messages](lang/en/messages.php) file and the other using the `$test_message` variable from [SampleMail](app/Mail/SampleMail.php). Learn more from the [Laravel documentation](https://laravel.com/docs/10.x/mail#configuring-the-view).

8. **Sending Emails**: With [SampleMail](app/Mail/SampleMail.php) ready, proceed to [TestController](app/Http/Controllers/Api/v1/TestController.php). In the `sendMail` method, check for uploaded files and pass them to [SampleMail](app/Mail/SampleMail.php) if present. Otherwise, pass the message. Use the `to` method from the `Mail` class to specify the recipient's email. Set the language with the `locale` method and use the `send` method to send the email. Explore these methods in the [Laravel documentation](https://laravel.com/docs/10.x/mail#sending-mail).

9. **Testing**: If configurations are correct, invoking the `send-mail` API with the required data will send an email to the specified address, including any attached files. Customize emails further with features like `cc`, custom headers, and tags. This guide provides a foundation for working with emails in Laravel.

This was the basic introduction to the Laravel-mails, there are still many topics we will explore about it in future branches.

## Note

- don't hesitate to initiate a new [discussion](https://github.com/mazimez/laravel-hands-on/discussions) to engage in comprehensive conversations with fellow developers.
- To simplify your interactions with the APIs developed in this section, you can make use of our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Documentation for Mails](https://laravel.com/docs/10.x/mail#introduction)
2. [Medium Blog About Mails](https://medium.com/@laraveltuts/how-to-send-mail-using-gmail-in-laravel-9-76d110779a4a)

