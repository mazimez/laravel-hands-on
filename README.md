# Middleware - Laravel 11

This section explain about what's changed in Middleware from Laravel 10 to Laravel 11. we also discussed about this in [localization-v11](https://github.com/mazimez/laravel-hands-on/tree/localization-v11), here we will dive deeper and see how we can use middleware for specific routes as well.

# Description

the main concept of middleware is still the same that it allows you to add common rules and logic to groups of routes (APIs). we already know that middleware can be created with command like `php artisan make:middleware OnlyAdminAllowed`.
In Laravel-10, each middleware first gets registered in `kernel` file and mapped to some key and then that key will be used to apply that middleware onto some route but Laravel-11 you don't need to register it or map it, you can directly use it on routes.


# Instructions
- first we will create 2 middleware, [OnlyAdminAllowed](app/Http/Middleware/OnlyAdminAllowed.php), [OnlyUserAllowed](app/Http/Middleware/OnlyUserAllowed.php) this middleware will be used to prevent normal user to access APIs that's made for admin only and vice versa.
- to apply this middleware, we will go into [v1](routes/api/v1.php) route and use `Route::middleware` method to first give middleware class and then use `group` method to group all routes and apply this middleware on all of them. we will do the same and apply our middleware `OnlyAdminAllowed` and `OnlyUserAllowed` on different routes in [v1](routes/api/v1.php). just like Laravel-10 but with new syntax.

# DIY (Do It Yourself)
- go over the new [v11 documentation](https://laravel.com/docs/11.x/middleware#introduction) for middleware and see what's new and how you can improve use of middleware.

## Next branch
 - `coming soon`
