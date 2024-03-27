# Authentication(Sanctum) - Laravel 11

Authentication with Sanctum is also updated a little in Laravel-11. before `Sanctum` package used to be installed by default in Laravel-10 but now it needs to be installed separately using `php artisan install:api`.

## Description

once you have installed `Sanctum` package in Laravel-11, it will generate migration files as well to store the info about `user authentication`.

also keep in mind that [User](app/Models/User.php) will not have `HasApiTokens` trait by default, you need to add it in your model. otherwise it will not generate token to authenticate our user.

also table(migration) will also get included with `install:api`.

## Instructions

- The APIs for login is similar to laravel-10, we create a route `users/login` that will take user's `email` and `password`, if it's correct then it will generate the token and return it, otherwise it will give an error.
- to check if authentication is successful, we will use `auth:sanctum` middleware and add new route `users/detail` to get the logged-in user's info.
- notice how we didn't add this middleware into [app.php](bootstrap/app.php) like `Localization` because that will apply it to all of our routes and we don't want that. we only want it to apply to specific routes.

## DIY (Do It Yourself)
- Sanctum has a feature where you can generate token for specific task or ability. here is the [doc](https://laravel.com/docs/11.x/sanctum#token-abilities). try to implement this into your project.
- you can also customize the token generation process to use a different way to generate token(maybe a different algorithm). here is the [doc](https://laravel.com/docs/11.x/sanctum#token-abilities). try to customize the token generation process and use a different algorithm to generate token.


## Resources

- [laravel-doc for sanctum](https://laravel.com/docs/11.x/sanctum#main-content)

## Next branch
 - `coming soon`
