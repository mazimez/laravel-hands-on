# Migration - Laravel 11

In this section we focus on Migration for Laravel 11. there hasn't been much change in how we use migration generally but there are some changes that makes our work with handling migrations files easy.

## Description

in Laravel-10, the default Database connection was `mysql` but in Laravel-11 it's been changed to `sqlite` but we will stick with `mysql`. also you notice there is a new file [database.sqlite](database/database.sqlite) that might be useful when using `sqlite` but for now we will leave it as it is.

also in older versions, migrations for `users` only contains info about `users` but in Laravel-11 it will contain info about `users` and other tables like `password_reset_tokens` and `sessions` as well. also the timestamp of these default migration files is also been updated to `0001_01_01_***`.

also table(migration) for sanctum package is also not included in Laravel-11, but you can always get it with `php artisan install:api` command which we already did.

## Instructions

- creating migration file in laravel-11 is similar to laravel-10 with command like `php artisan make:migration create_posts_table` will create [2024_03_25_150754_create_posts_table](database/migrations/2024_03_25_150754_create_posts_table.php) file.
- the users table will also gets updated.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- go over [laravel-doc for migration](https://laravel.com/docs/11.x/migrations#introduction)

## Resources

- [laravel-doc for migration](https://laravel.com/docs/11.x/migrations#introduction)

## Next branch
 - `coming soon`
