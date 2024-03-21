# Exception Handling - Laravel 11

In this section we focus on exception handling for Laravel 11. we will see what's changed from laravel-10 and how we can optimize exception handling in Laravel 11.

## Description

in Laravel-10, we used to have a `Handler.php` file where we can set-up all of our different exception and how we can handle it. now in laravel-11 there is not `Handler.php`, instead it is configured in [app.php](bootstrap/app.php) where we can set-up all of our different exception. you can learn more about it from [laravel-11-doc](https://laravel.com/docs/11.x/errors#introduction)

we can either directly check for different exception in [app.php](bootstrap/app.php) or have a separate file where we handle all exception and just use it in [app.php](bootstrap/app.php). so we will create a separate file for it.

## Instructions

- we will create a new trait [ExceptionHandler](app/Traits/ExceptionHandler.php) with command like `php artisan make:trait ExceptionHandler`, so that we can use it in [app.php](bootstrap/app.php).
- In [ExceptionHandler](app/Traits/ExceptionHandler.php), we create 1 method `handleApiException` that's used to take care of any exception we have in APIs. the exception that happen in `WEB` can be directly handled by Laravel's default methods. in that `handleApiException` method we check for each type of exception like `QueryException`, `ValidationException`,`ModelNotFoundException` etc. 
- we use [ApiResponser](app/Traits/ApiResponser.php) to send the JSON response explaining the error. you can change the message you want to show in response and also status code of that `HTTP response`. so this way you can customize your exception handling for APIs and if you want you can do the same for WEB exception as well.
- now there are couple of more updates in `Laravel-11` as well, in the old version we had variables like `$dontReport` and `$dontFlash` that we can use to hide some fields in error response. in Laravel-11, we can do the similar thing by accessing this variables using methods like `dontReport` and `dontFlash` on the `$exceptions` variable. `dontFlash` already has data like `current_password`, `password` added by default and you can add any other data as well.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to add more exception for API and also give a custom message that's more understandable by customer. 
- try to implement exception for WEB as well.
- Laravel-11 also support reporting these exceptions to some external service like `sentry` and `flare`. we cover this topic in future branch as well till then try to research about it on your own.

## Resources

- [laravel-11 doc for exceptions](https://laravel.com/docs/11.x/errors#introduction)

## Next branch
 - `coming soon`
