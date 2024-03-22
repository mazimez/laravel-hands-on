# Localization - Laravel 11

In this section we focus on Localization for Laravel 11. we will see what's changed from laravel-10 and how we can still get the same results

## Description

in Laravel-10, we used to create a new middleware for `localization` and register it in `kernal` file but in Laravel-11 there is no `kernal` file anymore. instead similar for other topic, registering middleware can be done in [app](bootstrap/app.php)

here we can configure `withMiddleware` method and register our middleware similar to what we did in laravel-10. you can learn more about it from [Laravel-11 doc](https://laravel.com/docs/11.x/localization).

also in Laravel-11, the `Lang` folder isn't included by default, but you can get that with command `php artisan lang:publish`. you can also add new files for different languages in that folder as well.

## Instructions

- first we will create a new middleware [HandleLocalization](app/Http/Middleware/HandleLocalization.php) with command like `php artisan make:middleware HandleLocalization`, and we put logic where we check in header of `X-App-Locale` and if it has valid language key then  we set the app's language with `setLocale` method.
- once that middleware is created then we will register it in [app](bootstrap/app.php) in `withMiddleware` method. with method of `append` we can add this middleware at the end of default middleware. there is also `prepend` method that will add this middleware at the beginning of default middleware.
- once we add that middleware then that will be applied all of our routes(`WEB` and `API` both). we also update [v1](routes/api/v1.php) route and use `messages.test` to return the message language wise. now you can check the API with postman and see that it returns data based on language set in header.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- as you know that this middleware is applied to `WEB` and `API` routes but you can also update this in a way that it only get's applied on `API` or only applied on `WEB`.

## Resources

- [laravel-11 doc for localization](https://laravel.com/docs/11.x/localization)

## Next branch
 - `coming soon`
