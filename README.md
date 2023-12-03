# Polymorphic Relationship (Part 2)

In this section, we will explore the versatile concept of polymorphic relationships and their application in different scenarios. As demonstrated in Part 1, polymorphic relationships allow us to associate a single resource (table) with multiple resources (tables) through the use of a single extra table. However, we can take this approach a step further and not only store IDs but also additional data in the extra table.

## Description

In our current example, we have a table named `post_files` that stores all the files related to a post. Now, we want to introduce a new feature allowing users to create albums to store images and videos privately. These albums should be specific to each user, and only the user and the admin should have access to view and delete them.

To implement this feature, one might consider creating another table, such as `user_file`, to store information about the user's files or albums. However, this approach would increase the number of tables, and it would lead to a similar situation every time we want to add files to any resource.

Instead, we will leverage polymorphic relationships to store all files in a single table (`files`), connecting it to different tables like `posts`, `users`, etc.

## Files

The changes and additions in this branch are reflected in the following files:

1. [2023_07_29_183155_create_files_table](database/migrations/2023_07_29_183155_create_files_table.php): This migration creates the new `files` table to store all files in the system.
2. [Post](app/Models/Post.php) and [File](app/Models/File.php): Models have been updated to utilize polymorphic relationships for files.
3. [PostSeeder](database/seeders/PostSeeder.php) and [UserSeeder](database/seeders/UserSeeder.php): Seeders are updated to use the new `files` table and add some sample data.
4. [FileFactory](database/factories/FileFactory.php): A new factory for the new file model/table has been added.
5. [FilePolicy](app/Policies/FilePolicy.php): A policy for the new File model/table has been created.
6. [UserFileController](app/Http/Controllers/Api/v1/UserFileController.php) and [PostFileController](app/Http/Controllers/Api/v1/PostFileController.php) and other controllers: Controllers are updated to utilize the new `File` model with polymorphic relationships.
7. [v1](routes/api/v1.php): New routes have been added for the album feature.
8. `REMOVED`: The migration and model for `post_likes` are removed.

## Instructions

Please follow the step-by-step instructions below to implement the changes and leverage the available resources effectively:

1. **Migration Setup**: Begin by creating a new migration for the `files` table. This migration should contain a `morphs` method to connect the `files` table to any other table. Additionally, add columns like `user_id`, `file_path`, and `type` to store information about the file itself and the user who added it. Notably, we are storing actual data in the polymorphic table, which differentiates it from the `likables` table, where we only store the IDs (connections) between tables.

2. **File Model**: Next, create the [File](app/Models/File.php) model. In this model, establish three relationships: `owner`, `user`, and `post`. The `owner` relationship represents a `belongsTo` connection with the `User` model, signifying that the user owns the file. The `user` and `post` relationships are `morphTo` connections, associating the file with the model it belongs to. For instance, if the file is added to a post, the `post` relationship returns the `Post` model; if it's added to a user's album, it returns the `User` model. Additionally, remember to use the `withoutGlobalScope` method to remove the global scope applied to the `Post` model, ensuring that the `post` relationship always returns the post model, regardless of its status (active or not).

3. **Update Post Model**: Modify the [Post](app/Models/Post.php) model to use the new [File](app/Models/File.php) model instead of the old [PostFile](app/Models/PostFile.php) model. Replace the `hasMany` relationship `files` with the `morphMany` relationship, utilizing the [File](app/Models/File.php) model to store all file-related information. Follow the same process for the `file` relationship. Repeat this step for the [User](app/Models/User.php) model as well to add the `files` relationship and enable the `User` model to store files on itself.

4. **Update PostController**: Adjust the [PostController](app/Http/Controllers/Api/v1/PostController.php) as it currently handles file storage directly using the [PostFile](app/Models/PostFile.php) model in the `store` and `update` methods. Update this part to use the `create()` method on the `files` relationship, allowing direct storage of the file path into the new `files` table. This way, when you call the post-create API and add files, they will be added to the new `files` table instead of the `post_files` table. Note that other methods like `index` and `show` in the controller are already adapted to use the new table since they utilize the `files` relationship.

5. **Update PostFileController and FilePolicy**: Further update the [PostFileController](app/Http/Controllers/Api/v1/PostFileController.php) since it still attempts to delete from the `PostFile` model. replace the `PostFile` model with the `File` model in the parameter of the `destroy` method. Additionally, create a new [FilePolicy](app/Policies/FilePolicy.php) specifically for the new `File` model, as the old policy was designed for the `PostFile` model. Note that in this new policy, we create a new method, `deletePostFile`, specifically for handling files related to posts. Moreover, when we get `$file` in this method, we use the `post` relationship on it to ensure that this `$file` is connected to a post. We also check for other conditions as required. By doing so, the `Post` resource is now entirely connected to the `File` model rather than the `PostFile` model. Apply a similar approach to the `User` model to enable the addition of the `Album` feature.

6. **Update Routes**: In the [v1](routes/api/v1.php) file, add routes for user-albums (`user/files`). Create three APIs: `index`, `store`, and `delete`. Create the [UserFileController](app/Http/Controllers/Api/v1/UserFileController.php) and implement the three methods mentioned above. Use the [FilePolicy](app/Policies/FilePolicy.php) created earlier to verify whether the user is allowed to perform these actions. Utilize the `files` relationship on the [User](app/Models/User.php) model to retrieve the list of files (album) from any user and enable the addition and deletion of those files. With these changes, you can now call these APIs to add files as albums for users, and these files will be stored in the same `files` table as the `Post` files. Therefore, there is no need to create another table for this feature.

7. **Update Seeders**: Update the seeders to incorporate the changes related to polymorphic relationships. In the [UserSeeder](database/seeders/UserSeeder.php), when looping through each user to add followers, use the [File](app/Models/File.php) model to first create some sample files for each user. Utilize the `for()` method to connect the `File` model with each user and provide the relationship name `owner` as a second parameter. This step ensures that the seeder does not attempt to call the `user` relationship on the `File` model, which is intended for another purpose (policy). After creating the files and storing them in the `$files` variable, use the `file()` relationship on the [User](app/Models/User.php) model and call the [`saveMany`](https://laravel.com/docs/10.x/eloquent-relationships#the-save-method) method to save multiple files simultaneously. Similar adjustments can be made to the [PostSeeder](database/seeders/PostSeeder.php) to add data for the polymorphic relationship. Note that adding data for polymorphic relationships in seeders and factories requires a slightly different approach than usual. For more details, refer to the [Laravel documentation on morph-to relationships](https://laravel.com/docs/10.x/eloquent-factories#morph-to-relationships).

8. **Final Step**: Now that the seeders are ready, execute `php artisan migrate:fresh --seed` to add all file data into a single `files` table. By following this approach, you can reduce the number of tables in your database while relying on Laravel's powerful relationships and methods for data manipulation instead of custom queries.

Polymorphic relationships are powerful and can be highly beneficial for implementing unique features. However, they can also be complex and challenging to understand fully. I recommend focusing on this topic and practicing with your own examples to deepen your understanding.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- there comes a time where your requirements may not be fulfilled by basic polymorphic relationship. for example, you need to connect 1 resource with some `pivot` table that may not have any primary key or may be to some resource that's not even stored in Database but in Cache or some other place. in that time, you may need to implement your own type of relationship. defining your own custom relationship will greatly improve your understanding about relationships, so you should try to do it.



## Note

- After this branch, we will proceed to remove the [2023_05_14_062725_create_post_files_table](database/migrations/2023_05_14_062725_create_post_files_table.php) migration and [PostFile](app/Models/PostFile.php) model, as they are no longer required due to the successful implementation of the polymorphic relationship.
- If you have any doubts regarding polymorphism or any other topic in this guide, feel free to open a new [discussion](https://github.com/mazimez/laravel-hands-on/discussions) to engage in detailed discussions with other developers.
- For your convenience, you can use our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection) to interact with the APIs created in this section.

## Reference

For additional information and further insights, you may refer to the following resources:

1. [Laravel Documentation for Many To Many (Polymorphic)](https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-polymorphic-relations)
2. [Use Cases for Polymorphic Relationships](https://blog.logrocket.com/polymorphic-relationships-laravel/)

