# Seeder and Factory

Seeders and factories are essential components in Laravel for adding sample or dummy data to your database. They provide a convenient way to populate your database with data required for your system to run properly.

## Description

Seeders are used to add initial data to your database, such as creating an admin user, adding categories to an e-commerce system, or populating states and cities for a social media application.

Factories, on the other hand, allow you to generate realistic and random data for your database tables. They are particularly useful when you need to create multiple records with different values quickly.

## Files

- [UserSeeder](database/seeders/UserSeeder.php): Seeder file for populating the `users` table.
- [PostSeeder](database/seeders/PostSeeder.php): Seeder file for adding data to the `posts` table.
- [DatabaseSeeder](database/seeders/DatabaseSeeder.php): Seeder file responsible for running all other seeders.
- [PostFactory](database/factories/PostFactory.php): Factory file for generating data for the `posts` table.
- [UserFactory](database/factories/UserFactory.php): Factory file for generating data for the `users` table.

## Instructions

To use seeders and factories in your Laravel project, follow these steps:

1. Open the `database` -> `seeders` folder. You'll find a file named `DatabaseSeeder.php`, which is used to run all the seeders in your project.

2. Let's create a seeder for the `Post` model as an example. Use the command `php artisan make:seeder PostSeeder` to generate a seeder file. Note that the seeder name should follow PascalCase and end with `Seeder`.

3. In the seeder file, you can write the code to create and add dummy/sample data to the database. For instance, in `UserSeeder` you can add a default user with an email of `test@gmail.com` and a password of `password` (encrypted form)

4. If you need to create multiple users with random data, you can utilize factories. To create a factory for a model, use the command `php artisan make:factory PostFactory`. This will generate a new factory file in the `factories` folder.

5. In the generated [PostFactory.php](database/factories/PostFactory.php) file, you can use the [Faker](https://github.com/FakerPHP/Faker) library to generate random data for the columns in the table. You can also define separate methods in the factory to provide specific values for certain columns. For example, in [UserFactory.php](database/factories/UserFactory.php), we have `unverified()` and `verified()` methods to create users with specific attributes.

6. Once the factory is ready, you can use it in the seeder to generate any amount of data you need. For example, `User::factory(10)->unverified()->create()` will create ten unverified users.

7. You can also leverage relationships defined in your models to generate data related to other models. We will cover this topic in more detail in later branches.

8. To run a specific seeder, use the command `php artisan db:seed --class=UserSeeder`. This will execute the `UserSeeder` and populate the database with users.

9. Usually, you'll have multiple seeders, and running them individually is not efficient. To run all seeders at once, you need to register them in the [DatabaseSeeder.php](database/seeders/UserSeeder.php) file.

10. Add each seeder class to an array in the `run()` method of `DatabaseSeeder.php`. The seeders will execute in the order they appear in the array.
11. you can use `php artisan migrate:fresh --seed` command to clear your existing Database and run all migration and also run all seeders, all of that in just 1 command.

## Resources

- [Laravel Documentation for Seeders](https://laravel.com/docs/10.x/seeding#writing-seeders)
- [Laravel Documentation for Factoris](https://laravel.com/docs/10.x/eloquent-factories#main-content)