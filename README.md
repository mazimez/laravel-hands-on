# Migration

The migration feature allows your project to create and manage the database directly from the code, eliminating the need for separate SQL queries.

## Description

With Migration, you can easily create tables that align with your project's requirements, defining all the necessary columns and relationships between them. It also provides a convenient rollback feature to revert changes and the ability to clear the entire database if needed.

## Files

- [2023_05_14_062417_create_posts_table.php](database/migrations/2023_05_14_062417_create_posts_table.php): new migration file for new table `posts`

## Instructions

To use Migration, navigate to the `database` -> `migrations` folder. You will find default files for tables like `users` and `personal_access_tokens`.

In our example, we will create migration files for a system where users can create posts, comment on them, and like them.

1. To create a table, use the command `php artisan make:migration create_table_name_table`. This will generate a file for the specified `table_name`.
2. Each migration file for a table begins with a timestamp. Laravel executes the migrations in the order of these timestamps, with older files running first. If you want a table to be created before the default tables, simply modify the timestamp to an earlier date than the default files.
3. In your table migration files, you can define relationships between tables using the `foreignId()` method. For example, in the [2023_05_14_062417_create_posts_table.php](database/migrations/2023_05_14_062417_create_posts_table.php) file, we created a relationship with the `users` table.
4. It is recommended to make all fields in the table nullable using the `nullable()` method. Additionally, consider assigning default values to columns as good practice.
5. When naming tables, use meaningful names that reflect their purpose. For instance, the table storing post comments can be named `post_comments`, and the table for post likes can be named `post_likes`. Table names should be in plural form, such as `users` and `posts`.
6. Similarly, for column names, choose descriptive names that indicate their data type. For example, if a column has a boolean data type, prefix its name with `is_`, such as `is_blocked` or `is_active`. If a column represents a datetime value, append `_at` at the end, like `created_at`, `updated_at`, or `deleted_at`.

Once you have defined your migration files, run the `php artisan migrate` command to create all the tables in the database.
remeber to set-up your .env file to connect to a DataBase

## Resources

- [Laravel Documentation](https://laravel.com/docs/10.x/migrations)