# Middleware

Middleware in Laravel allows you to add common rules and logic to groups of routes (APIs). Laravel provides basic useful middleware for authentication, and you can also use it for localization, as discussed in our [localization](https://github.com/mazimez/laravel-hands-on/tree/localization) branch.

## Description

In this example, we will use middleware to apply generic rules to all of our APIs.

Each user will be assigned a `type`, which can be either `user` or `admin`. The `user` type represents end users who utilize the system, while the `admin` type supervises user-added posts, verifying or blocking them.

An `admin` user is restricted from adding, updating, liking, or commenting on any posts. However, `admin` users can view all posts, comments, followers, and followings of any user. Additionally, they have the ability to verify, block, and delete any post.

We will use middleware to enforce most of these rules, and in some cases, we'll utilize `policy` as well.

## Files

The following files have been updated/added in this branch:

- [OnlyAdminAllowed.php](app/Http/Middleware/OnlyAdminAllowed.php) and [OnlyUserAllowed](app/Http/Middleware/OnlyUserAllowed.php): New middleware to restrict users based on their type.
- [2014_10_12_000000_create_users_table](database/migrations/2014_10_12_000000_create_users_table.php): Added a new column `type` to the `users` table.
- [UserFactory](database/factories/UserFactory.php) and [UserSeeder](database/seeders/UserSeeder.php): Updated factory and seeder to include dummy data for the new `type` column.
- [PostController](app/Http/Controllers/Api/v1/PostController.php) and [PostIndexRequest](app/Http/Requests/Api/v1/PostIndexRequest.php): Added filters to allow only `ADMIN` users to see all posts.
- [PostPolicy](app/Policies/PostPolicy.php), [PostFilePolicy](app/Policies/PostFilePolicy.php), [PostCommentPolicy](app/Policies/PostCommentPolicy.php): Updated policies to enable admin users to delete any resource.

## Instructions

Please follow these instructions to implement the changes and make use of the available resources:

1. Update the migration to add a new field `type` in the `users` table with two possible values: `ADMIN` and `USER`. Define these values as constants in the [User](app/Models/User.php) model. This way, if you decide to change this value in the future, you won't need to modify it everywhere. Also, update the seeders and factories to include the new `type` value, and add one user with the `admin` type by default.

2. Create a new middleware using the command `php artisan make:middleware OnlyAdminAllowed`. This will create the [OnlyAdminAllowed](app/Http/Middleware/OnlyAdminAllowed.php) class, where you can add your rule/logic. Here, first check if the user is logged in with `AUTH`. If not, return an error with a `401` status. If the user is logged in, verify if their type is `ADMIN`. If not, return an error indicating that only admins can access this route. If the user is an admin, proceed with `$next($request)` to grant access.

3. Register this middleware in [Kernel](app/Http/Kernel.php) under `$routeMiddleware`. Use the key `only_admin_allowed` to reference it in your routes.

4. In the [v1](routes/api/v1.php) route file, use this middleware with `Route::group` to encompass all routes intended for admin use. For example, place the `user's list` route within this middleware since we don't want regular users to see all the users. Additionally, create two more routes for admin to verify and block posts, and include these routes in the same middleware. Now, if you attempt to call these APIs while logged in as a regular user, it will result in an error. Only admins will have access.

5. Create another middleware, `OnlyUserAllowed`, with similar functionality, but this time for `USER` type. Include routes like `post-create-update`, `comment-create-update`, and `follow-user` under this middleware. Now, when logged in as an admin, you won't be able to create posts or comments, but you can still view all posts and comments since they are outside the middleware's scope.

6. When admin users view the list of posts, they should be able to see all posts, including those that are `verified` or `blocked`. To achieve this, modify the [PostController](app/Http/Controllers/Api/v1/PostController.php) by removing the scope that filters out `verified` and `non-blocked` posts when the user is of type `ADMIN`. This way, admins can see all posts and decide which ones to block or verify.

7. Implement filters on the `posts` list to allow admins to view only `blocked` or `non-blocked` posts, as well as verified or non-verified posts. To ensure that these filters are available only to `ADMIN` users, use the `authorize` method in the [PostIndexRequest](app/Http/Requests/Api/v1/PostIndexRequest.php). Check if the parameters `is_blocked` or `is_verified` are present in the request, and if they are, ensure that the user is an `ADMIN`. If not, throw an exception with a message indicating that only `ADMIN` users can use these filters. The exception will be handled by the [Handler](app/Exceptions/Handler.php) we created in the [exception-handling](https://github.com/mazimez/laravel-hands-on/tree/exception-handling) branch. This approach restricts specific parameters to certain types of users in any `Request`.

8. Now, the new filter will only be available for `ADMIN` users and not for regular `USER` types. Additionally, update the `Policies` files to allow `ADMIN` users to delete any resources, such as `posts`, `comments`, etc.

so that's how you can use middleware to add your common `rules/logic`. you can see that we don't need to update our controllers much, all of this `access-control` is handled by `middleware`, `policy` and `request`. this is a good way to separate our `LOGIC` from `RULE`.

try to follow this approach in all of you projects, this will make it easy to update your `rules` without effecting your `logics`.


## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- in our example, most of our middleware's only check things with logged-in user but middleware can be used to check things in request like parameters, headers etc. so try to make more middleware like that.



## Reference

1. [Laravel Documentation for Middleware](https://laravel.com/docs/10.x/middleware)
2. [Some Examples of Middleware](https://www.tutorialspoint.com/laravel/laravel_middleware.htm)
3. [W3Schools Documentation](https://www.w3schools.in/laravel/middleware)
