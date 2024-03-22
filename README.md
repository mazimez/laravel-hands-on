# Laravel 11

This section is the transition between Laravel 10 and Laravel 11. the codebase is updated with Laravel-11's structure.

from this point on, new branches will be added based on this branch and it will re-explain some topics that's been changed in Laravel-11.

any folder or file that changed in new Laravel-11 will be mentioned and explained. you can also see the new folder structure from [laravel-doc](https://laravel.com/docs/11.x/structure#introduction)

## Description

with new Update of Laravel 11, there are lot of changes in the codebase and how to use it. things like `Exception handling`, `routes` and `scheduling` is updated and move to another place then it used to be.

we will go through each change like this and re-explain the topics with new code whenever needed.

with new updates there are lot of new `artisan commands` that we can use. some of them are
- `php artisan config:publish` : to publish default config files so we can change them.
- `php artisan install:api` : to set-up project to develop APIs.
- `php artisan make:trait`: to directly make any trait
- `php artisan make:class`: to directly make any class

you can visit [laracasts](https://laracasts.com/series/whats-new-in-laravel-11) for more detailed overview over whats changed plus you can go over our new branches for laravel-11 as well.


## Instructions

- our examples are focused on API, so first we will make sure that laravel-11 is also set-up to develop APIs. you have probably noticed that in `routes` folder there is no `api.php` by default. for that we will first run the `php artisan install:api` command. this will update our codebase and also add [api.php](routes/api.php) file for us. this also install the `sanctum` package for `authentication`.
- you have also noticed that in `.env` file, there are lot of new variables. we will talk about them in later branches, for now just update our `DB` related variables so it will use `mysql` instead of `sqlite` since that's what given to us as default. you can keep it `sqlite` if that's what you use.
- since we already have a codebase in laravel-10, we will just go over all the topics explained there and just re-explain them with Laravel-11. not all of the topics will be re-explained, only the ones that are changed will be re-explained. so topics like `eloquent-relationships`,`scope-attribute`,`policies` wont be re-explained but topics like `exception-handling`,`middleware`,`scheduler-cron` will be re-explained. 
- also at the end of each readme file, there will be a `next` section which will point you to the next branch to make it easy to follow.

We encourage you to actively engage with the content, experiment with the code, and explore Laravel's capabilities.

## Note

- if you face any difficulties in the readme file or finding the correct topic/branch for your need then you can ask about this in [Github discussions](https://github.com/mazimez/laravel-hands-on/discussions)

## Resources

- [laravel-11 doc](https://laravel.com/docs/11.x/)
- [laracasts on laravel-11](https://laracasts.com/series/whats-new-in-laravel-11)

## Next branch
 - [exception-handling-v1](https://github.com/mazimez/laravel-hands-on/tree/exception-handling-v11)
