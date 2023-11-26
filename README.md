# Localization

The localization feature allows your project to handle content in different languages effectively.

## Description

In this project, localization is implemented using a Middleware. This Middleware checks the header in API calls, and if the header for localization is provided, the project dynamically sets its language based on the header value.

## Files

-   [localization.php](app/Http/Middleware/localization.php): This file contains the middleware code responsible for handling different languages. Add the `localization` middleware to your project.
-   [Kernel.php](app/Http/Kernel.php): Register the `localization` middleware in the Kernel file, giving it a suitable name such as "localization".
-   [v1.php](routes/api/v1.php): Include the middleware for all the routes that need to be localized, such as the test route in the v1.php file.
-   [messages.php](lang/en/messages.php): Create a new file named `messages.php` in the `lang/en` folder (or any other desired language folder). This file will contain all the language keys used in your project.
-   [Handler.php](app/Exceptions/Handler.php): update exception handling file or any other file with static string and replace it with keys from `lang` folder

## Instructions

To implement Localization in your project, follow these steps:

1. Create a middleware named [localization.php](app/Http/Middleware/localization.php) that handles and determines the required language based on the headers passed in the API call.
2. Register this middleware in the [Kernel.php](app/Http/Kernel.php) file, enabling its usage in your project's routes.
3. Before using the middleware, explore the `lang` folder, which contains a default `en` folder for English language files.
4. Create additional language folders based on the languages needed for your project. For example, you can create a `sv` folder for Swedish language support.
5. Each language folder should include files like `auth.php`, `pagination.php`, etc., which store language-specific strings. Additionally, create a new file for each language to store your project's output messages.
6. Once you have set up your language folders, you can utilize the language keys you defined in your routes and controllers using the `__('messages.key_name')` syntax. Here, `messages` refers to the file storing the output messages, and `key_name` represents the translation key.

To test the implementation, you can use tools like Postman to make API calls, where you have the option to provide custom headers. Pass a header key-value pair (e.g., `X-App-Locale`) to specify the desired language, and the project will dynamically change the language based on its value.

more detailed info about middleware is given in [middleware](https://github.com/mazimez/laravel-hands-on/tree/middleware) branch. you can also look into it.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to customize the [localization.php](app/Http/Middleware/localization.php) and take the language information from different key of header or maybe entire different way then using header.
- we created only 1 new `messages` file to store all of our language keys, but you can try to maintain different files related to different modules in your project(to ignore having too large files also merge conflicts while working in team).
- try to add new languages that has "right-to-left" (RTL) writing like `arabic` or `urdu` and see how your projects adapts to that languages.

## Resources

-   [Laravel Documentation](https://laravel.com/docs/10.x/localization)
