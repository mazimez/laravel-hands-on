# API Versioning

This branch focuses on versioning of APIs to manage changes and keep different versions separate while ensuring compatibility.

## Description

In this project, API versioning is implemented to maintain the stability of existing APIs and introduce new features or updates without breaking the functionality for existing users. The initial version, V1, is implemented and deployed on the production server. Subsequent versions, such as V2, are created for introducing new features or making changes while keeping the older versions intact.

## Files

-   [RouteServiceProvider.php](app/Providers/RouteServiceProvider.php): Updated this provider to configure the usage of version-specific route files, 'v1.php' and 'v2.php', based on the requested API version.
-   [v1.php](routes/api/v1.php): Contains routes specific to the V1 version of the APIs.
-   [v2.php](routes/api/v2.php): Contains routes specific to the V2 version of the APIs.

## Instructions

To implement API versioning in your project, follow these steps:

1. Update the [RouteServiceProvider.php](app/Providers/RouteServiceProvider.php) file to instruct Laravel to use version-specific route files instead of the default routes.
2. Create a new folder, `api`, inside the `routes` folder. Inside the `api` folder, create separate route files for each version of the APIs, such as `v1.php` and `v2.php`. You can define your own folder structure if desired.
3. Add test routes in the version-specific route files, for example, `/test` route in both `v1.php` and `v2.php`. You can access these routes in the browser using the endpoints `api/v1/test` and `api/v2/test`. Depending on the version, the returned response will vary.

This approach allows you to differentiate API endpoints based on their version, ensuring backward compatibility and enabling different versions to coexist. When using controllers for each route, you can organize them into separate folders like 'v1' and 'v2', accommodating future versions as needed.

## Resources

-   [Laravel 8 API Versioning](https://dev.to/dalelantowork/laravel-8-api-versioning-4e8)

For additional examples and information about API versioning in Laravel, refer to the provided resource link.
