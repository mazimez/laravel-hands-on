# Web Basics

Till now we focus on the API part of Laravel, now we will focus on the web part. Laravel provides very rich and powerful things to make Websites. we already learn a little bit about blade files that will be used in the web part of Laravel.

We also have tool/tech like `LiveWire`,`Vite`,`TailWind`, `Filament` etc. that help us make websites faster. we will look into these topics in later branches.

Laravel also has a [starter-kits](https://laravel.com/docs/10.x/starter-kits) that you can see and implement. but we will go with simpler approach so it will be easy to understand.

## Description

In this section, we just get to know the basics of Blade files and also update our WEB part a little bit. we added the login page in web in [indexing](https://github.com/mazimez/laravel-hands-on/tree/indexing) and [fcm-notification-part-1](https://github.com/mazimez/laravel-hands-on/tree/fcm-notification-part-1) branches. we will update that part and try to implement an Admin panel for our admin where he/she can check on users and posts.

building whole admin panel is will take more then just few branches. so we focus on only important parts that we must understand, other parts can be done later(as DIY). so for this branch, we prepare some BASE blade files that we can use to show some UI like sidebar and navigation on web pages.

in later branches, we will see how we can add things like `users-list`, `user-crud` etc. in WEB.

we are using 1 template from CodePan. the [Admin Panel](https://codepen.io/ajeeb/pen/dRLQRR) template by [ajeeb](https://codepen.io/ajeeb) is a good template that you can use to get some basic UI of admin panel. you can also create your own UI elements from scratch.

## Files
1. [DashboardController](app/Http/Controllers/Web/DashboardController.php) and [UserController](app/Http/Controllers/Api/v1/UserController.php): updated the controllers to use new `WEB blade files` and `UI`.
2. [styles](public/css/styles.css) & [app](public/js/app.js): some `CSS` + `JS` to make UI attractive.
3. [main](resources/views/UI/base/main.blade.php),[sidebar](resources/views/UI/base/sidebar.blade.php),[topbar](resources/views/UI/base/topbar.blade.php): added new blade files to show the UI.
4. [web](routes/web.php): new route added for admin panel.
6. `other changes made by laravel-pint for formatting`

## Getting Started

1. first we will start with rearranging our blade files, we will make 1 `UI` folder in `views` there we will put all of our blade files related to Admin panel(like Login page, blade files to handle CRUD on `User` and `Post` etc.). in the we make sub-folders like `auth`, `base`. in `auth` we put our login page and any other page related to user's authentication flow. in `base`, we will put different blade files for NavBar, SideBar, TopBar etc. of our admin panel.

2. In [main](resources/views/UI/base/main.blade.php) blade file, we first add some `JS` and `CSS` libraries like `Bootstrap`, `Jquery` and `Font Awesome` to get some basic set-up for our Admin panel UI. also we use `asset` method to get the path of our JS and CSS files. since our app start from `public` folder, we can use `asset` method to get the path of our JS and CSS files. there are more methods like `asset` that you can learn from [Laravel-doc](https://laravel.com/docs/10.x/helpers#miscellaneous-method-list).

3. we can also use content from another blade file into our main blade file with `@include`, we have included blade files like [sidebar](resources/views/UI/base/sidebar.blade.php), [topbar](resources/views/UI/base/topbar.blade.php) with `@include` to show our UI for `sidebar` and `topbar`. In [sidebar](resources/views/UI/base/sidebar.blade.php) we put different routes for different sections like `Dashboard` and `Users` etc. so user can navigate throw these routes.

4. there is also method like `@yield`, `@extends` and `@section` that helps in extending our blade templates. look at [users](resources/views/UI/users.blade.php). here, we are extending our `main` blade file with `@extends` and in [main](resources/views/UI/base/main.blade.php) blade file we use `@yield` to indicate blade engine that another blade file will extend it and put it's own content here. in [users](resources/views/UI/users.blade.php) blade file we use `@section` and put our content there, this content will be putted inside the [main](resources/views/UI/base/main.blade.php) blade file. you can learn more about layout Extending from [Laravel doc](https://laravel.com/docs/10.x/blade#layouts-using-template-inheritance)

5. we will also update our [UserController](app/Http/Controllers/Web/UserController.php) and update our `login` method a little where first we find the user with email and verify the password. we then use `Auth` facade's login method and pass our `$user` variable in it. this will handle the login process based on [auth](config/auth.php) config, in that config we have set it to authenticate with session, so Laravel will handle that on it's own.

6. now that our blade files are set up, you can `serve` the project and check our UI. it should show you the login page first and then the dashboard with sidebar. you can navigate into different sections as well. all of this is handled by [main](resources/views/UI/base/main.blade.php),[sidebar](resources/views/UI/base/sidebar.blade.php),[topbar](resources/views/UI/base/topbar.blade.php) blade files.

7. you can customize this file to change the UI and make it look better, but try to focus on more on using the Blade template and it's different methods like `@yield`, `@extends` and `@section`. there are lot of other methods that we will use in later branches. this branch is just to get to know the basic of Blade files and the whole WEB part of Laravel.

## DIY (Do It Yourself)

Explore additional tasks:

- try to update the UI and also show some data of logged-in user into dashboard.
- try to create a register page as well that register new users. even though this Admin panel us just for admin type users but register page would be a good practice to get familiar with Blade files.

## Additional Notes

- In next branch, we will focus on showing the list of users in to our admin panel. we also try to add filters and sorting on that user's list.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel documentation for blade](https://laravel.com/docs/10.x/blade)
2. [Basic of Blade](https://www.javatpoint.com/laravel-blade-template)
