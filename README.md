# Authentication(Sanctum)

Authentication is a crucial process where users verify their identity to perform specific tasks within a system. In the context of APIs, authentication is primarily done using tokens, such as Bearer tokens or JWT tokens.

## Description

 Laravel provides a package called Sanctum that simplifies the implementation of authentication in your project.

## Files

- [UserController.php](app/Http/Controllers/Api/v1/UserController.php): Contains the UserController class responsible for handling authentication-related tasks.
- [LoginRequest.php](app/Http/Requests/Api/v1/LoginRequest.php): Defines the LoginRequest class used to validate the API call parameters.
- [v1.php](routes/api/v1.php): Adds the necessary routes for login and other API endpoints.

## Instructions

To implement authentication, follow these steps:

1. Create a route (API) that accepts the user's email and password as parameters, verifies the password (referred to as the login API), and returns a Bearer token if the password is correct.

2. Create a controller named `UserController` to handle all user-related tasks. You can generate this controller using the following command: `php artisan make:controller Api/v1/UserController --api`. This command generates a controller within the `Api` folder and the `v1` subfolder. The `--api` flag adds default methods to the controller that will be used later.

3. Create a request class, `LoginRequest`, to validate the parameters required for the login API. Generate this request using the command `php artisan make:request Api/v1/LoginRequest`. This request should be created within the `Api` folder and the `v1` subfolder. Add the necessary validations to the `LoginRequest` class, such as verifying that the email is in the correct format and exists in the `users` table.

4. In the `UserController`, implement the login method. Use the `LoginRequest` to validate the parameters, then find the user with the given email and verify their password using the `password_verify` method.

5. If the password is correct, use the `createToken` method on the user object to generate a Bearer token for that user. Don't forget to add the `HasApiTokens` trait to the `User` model to indicate that Sanctum should use this model for authentication.

6. Once you have the token, return the user's data along with the token. To authenticate a user in any subsequent API calls, include the token in the header as a 'Bearer' token. Additionally, ensure that all APIs requiring user authentication are protected using the `auth:sanctum` middleware.

7. To test these APIs, you can use a client like Postman. We've provided a public Postman collection for this project, which you can access [here](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Resources

- [Laravel Documentation](https://laravel.com/docs/10.x/sanctum)
- [Authentication example](https://dev.to/shanisingh03/laravel-api-authentication-using-laravel-sanctum-edg)
