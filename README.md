# API versioning - Laravel 11

In this section we focus on API versioning for Laravel 11. we will see what's changed from laravel-10 and how we can optimize/minimize API versioning in Laravel 11.

## Description

in Laravel-10, we used to have a `RouteServiceProvider .php` file where we can set-up our API versioning. now in laravel-11 there is no `RouteServiceProvider.php`, instead similar to exception, it is also configured in [app.php](bootstrap/app.php). there is a method `withRouting` that can take several parameters for `WEB` and `API` routes. you can learn more about it from [laravel-11-doc](https://laravel.com/docs/11.x/routing)

here we can configure `withRouting` method and implement the same structure for API versioning that we have for laravel-10. for that we will create a new trait and put our API versioning logic there and then just use it in [app.php](bootstrap/app.php).

## Instructions

- if you have used the command `php artisan install:api` then `withRouting` method already has `api` parameter that connects it with [api.php](routes/api.php) but now we want it to connects to [v1](routes/api/v1.php) and [v2](routes/api/v2.php) with prefix `api/v1` and `api/v2`. to do that we can use `then` parameter on `withRouting` and further customize the API routes. you can learn more about this from [Laravel-doc](https://laravel.com/docs/11.x/routing#routing-customization)
- first we will create a new trait [RouteHandler](app/Traits/RouteHandler.php) with command like `php artisan make:trait RouteHandler`, so that we can use it in [app.php](bootstrap/app.php).
- In [RouteHandler](app/Traits/RouteHandler.php), we create 1 method `configureApiVersioning` that has similar code that we had in `RouteServiceProvider` for Laravel-10. keep in mind that it's returning a `Closure` or a function that will be given in `then` parameter of `withRouting` in [app.php](bootstrap/app.php).
- In [RouteHandler](app/Traits/RouteHandler.php) we configure 2 new route group with prefix `api/v1` and `api/v2` that will connects to [v1](routes/api/v1.php) and [v2](routes/api/v2.php).
- now if we try to call `api/v1/test` and `api/v2/test` then it will return the similar response that we had in laravel-10. so that's how you can configure API versioning in

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- you can further customize this `withRouting` method to have the routes in any way we want. try to customize it further for your `WEB` or `API` routes as well
- try to implement exception for WEB as well.

## Resources

- [laravel-11 doc for routing](https://laravel.com/docs/11.x/routing)

## Next branch
 - [localization-v11](https://github.com/mazimez/laravel-hands-on/tree/localization-v11)
