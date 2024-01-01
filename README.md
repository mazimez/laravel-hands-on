# Debugging with Laravel Telescope

Effective debugging is crucial as your project grows in complexity. It not only aids in identifying and resolving issues but also contributes to system optimization. Debugging can be performed manually by inspecting the entire codebase or by utilizing powerful tools designed for this purpose.

## Description

As we focus on the art of debugging, we introduce a new addition to our badge system – the badge awarded to users upon gaining their first follower. However, the primary emphasis remains on debugging our system effectively. To achieve this, we leverage a powerful tool provided by Laravel itself, known as "Laravel Telescope." This package captures and records a wide array of system actions, including API calls, SQL queries, email transmissions, and more. Subsequently, it allows us to delve into the specifics of each of these actions, facilitating the discovery of intricate bugs and performance optimizations. For a comprehensive guide, please refer to the [Laravel Telescope documentation](https://laravel.com/docs/10.x/telescope).

To integrate Laravel Telescope into your project, execute the following command:

```bash
composer require laravel/telescope
```

Once the package is installed, you'll need to run two additional commands to publish the required assets and perform necessary migrations:

```bash
php artisan telescope:install
php artisan migrate
```

Upon successful execution of these commands, you'll need to make adjustments to your `.env` file and certain configuration files to enable Telescope and configure it to record system actions. It's important to note that our intention is to use Telescope exclusively in the "Testing" and "Local" environments, avoiding its use in production. Therefore, the following instructions pertain to configuring Telescope for "Testing" or "Local" environments.

## Files

1. [BadgeSeeder](database/seeders/BadgeSeeder.php): Updated the seeder to add a new badge for the first follower.
2. [AppServiceProvider](app/Providers/AppServiceProvider.php) and [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php): Modified providers to support Telescope.
3. [app](config/app.php) and [telescope](config/telescope.php): Adjusted configuration files to align with Telescope requirements.
4. [UserFollowController](app/Http/Controllers/Api/v1/UserFollowController.php): Updated the controller to handle the new badge for followers.
5. [composer.json](composer.json): Updated the composer JSON to include the new package.
6. Telescope assets: Default Telescope assets have been included.

## Getting Started

1. Begin by updating the [BadgeSeeder](database/seeders/BadgeSeeder.php) to include a badge for "FIRST_FOLLOWER." Subsequently, modify the `toggle` method in the [UserFollowController](app/Http/Controllers/Api/v1/UserFollowController.php) to check if a user has one or more followers before adding or updating their badge. While this may not appear to be the most optimized solution, it is necessary to ensure that existing users receive the badge. Future branches may offer further optimization.

2. Now that the new badge is in place, let's delve into the world of "TELESCOPE." Once installed, update your `.env` file by adding two variables: `TELESCOPE_PATH` and `TELESCOPE_ENABLED`. The `TELESCOPE_PATH` variable defines the route where the Telescope user interface will be accessible, allowing you to inspect all recorded actions. You can choose any value here; "debug" is commonly used for debugging purposes. The `TELESCOPE_ENABLED` variable indicates whether Telescope is enabled; if set to "false," Telescope will neither record data nor be accessible at the defined route.

3. Open the [telescope](config/telescope.php) configuration file to customize how Telescope functions within your project. In the `watchers` section, you can control various watchers available in Telescope, each of which can be fine-tuned using environment variables. For an initial exploration, it's advisable to enable all watchers to fully harness the capabilities of Telescope. However, you have the flexibility to disable specific watchers as needed.

4. Upon installing Telescope, its `RouteServiceProvider` is automatically added to the [app](config/app.php) configuration. By default, it boots with every project run, but this may not be desired. To ensure that Telescope runs only in the "Testing" or "Local" environments, remove it from the [app](config/app.php) configuration and add it manually within the [AppServiceProvider](app/Providers/AppServiceProvider.php), where you can check the application's environment to be either "testing" or "local." Adjust this configuration according to your specific requirements, and refer to the [Laravel documentation](https://laravel.com/docs/10.x/telescope#local-only-installation) for further insights.

5. In the [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php), the `Telescope` package decides which actions to record (add entries for). In the `register` method, entries are filtered based on the environment. For the "local" environment, all data is recorded, while in the "testing" environment, only specific actions such as queries, mails, events, and logs are recorded. Customize this filtering to suit your needs, and consult the [Laravel documentation](https://laravel.com/docs/10.x/telescope#filtering-entries) for more details.

6. We also introduce a new method in the [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php) called `authorization`. This method helps determine which users have access to Telescope. Currently, we make Telescope accessible to anyone visiting its route, as it is intended for use in "testing" and "local" environments. However, in the future, access may be restricted to admin-type users. For now, we simply check if the application is in either the "local" or "testing" environment, granting access accordingly. Detailed information on authorization can be found in the [Laravel documentation](https://laravel.com/docs/10.x/telescope#dashboard-authorization).

7. With all configurations in place, you can serve your project and access Telescope by navigating to `http://127.0.0.1:8000/debug` or to the route defined in your `.env` file. The user interface provides various sections, including "requests," "commands," "schedule," "jobs," and more. In the "request" section, you can delve into the details of all APIs executed in your system. Parameters, responses, and other data are readily available for inspection. Additionally, there is a "mail" section that displays all emails sent by the system. To gain a deeper understanding of how Telescope operates, consider creating a new user using your APIs to populate different sections in Telescope.

8. At the top of the Telescope user interface, you'll find options to "pause recording," "clear entries," and "auto-load," among others. Enabling "auto-load" ensures that you don't need to manually refresh the page repeatedly. You can explore the various sections to determine which are most valuable for your specific use case. Keep in mind that Telescope operates exclusively in the "testing" or "local" environments and is not active in "production."

9. This concludes the implementation of Telescope into your system. While the basics have been covered,
 

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- there are many advanced features, such as "tagging" and additional "watchers," which can be explored in future branches. try to learn about them and use them on your own.
- just like `Telescope` there are other tools/packages that you can use for debugging like `Debug Bar`. try to use that in your project as well.

## Additional Notes

- In upcoming branches, we will continue to enhance "Telescope." Additionally, there are other debugging tools like [Debugbar](https://github.com/barryvdh/laravel-debugbar) that you may find useful.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel Telescope](https://laravel.com/docs/10.x/telescope)
2. [Getting Started with Laravel Telescope](https://blog.logrocket.com/getting-started-with-laravel-telescope-what-can-it-do-for-you-719aaef07941/)
