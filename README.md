# Eloquent Relationships

Eloquent Relationships are a crucial component of Laravel. They allow us to establish logical connections between resources in our code.

## Description

This section focuses on demonstrating how to use Eloquent Relationships rather than explaining their core concepts. If you're not familiar with these relationships, please refer to the [Laravel documentation](https://laravel.com/docs/10.x/eloquent-relationships) before proceeding with this section.

## Files

- [Post.php](app/Models/Post.php): Contains the defined relationships for use in other files.
- [PostSeeder](database/seeders/PostSeeder.php): Updated code that utilizes relationships.
- [PostCommentFactory](database/factories/PostCommentFactory.php), [PostFileFactory](database/factories/PostFileFactory.php): Added factories to generate dummy data.
- [PostController](app/Http/Controllers/Api/v1/PostController.php): Updated the controller to incorporate relationships.
- [PostCommentController](app/Http/Controllers/Api/v1/PostCommentController.php): New controller that also utilizes relationships.

## Instructions

We will use relationships to connect our `Post` model with `User` and other models, enhancing our seeders and APIs.

1. Define relationships in the [Post](app/Models/Post.php) model, such as `user`, `files`, `file`, and `comments`. Create a new model, [PostComment](app/Models/PostComment.php), and define additional relationships in it, including `post` and `user`. Repeat this process for other models as well.

2. Now that our relationships are defined, let's use them in the seeders. Review the [PostSeeder](database/seeders/PostSeeder.php) file, where we've updated the code to create default comments and files for each post using our defined relationships. By utilizing the `for` method on the factory, the foreign keys will be automatically populated in the database.

3. We've created [PostCommentFactory](database/factories/PostCommentFactory.php) and [PostFileFactory](database/factories/PostFileFactory.php) to generate dummy data for these resources. Now that we've used relationships in seeders and factories, let's incorporate them into our APIs (controllers).

4. Open [PostController](app/Http/Controllers/Api/v1/PostController.php) and examine the `index` method. We've used the `with` method on the `Post` model and added the `user` and `file` relationships to it. This attaches (preloads) the `User` and `PostFile` models with each `Post` when returning JSON. This is how you can include data from other models (tables) with your main model. There are other methods like `withCount`, `withSum`, `withMin`, etc., that operate on the same concept. You can read about them in the [Laravel documentation](https://laravel.com/docs/10.x/eloquent-relationships).

5. In the `index` method, notice that we use the `orWhereHas` function and pass the relationship `user` as a string when performing a search. This allows us to apply queries on the related `users` table, enabling us to search within the `users` table through the `posts` table. There are many other methods available, such as `whereDoesntHave`, `doesntHave`, etc.

6. Moving on to the `show` method, we utilize the `loadMissing` function, which loads the specified relationships only for that particular instance of the `Post` model. There are also functions like `loadCount`, `loadSum`, etc.

7. We've also added a new [PostCommentController](app/Http/Controllers/Api/v1/PostCommentController.php) that uses similar functions.

These are the basics of Eloquent Relationships. Familiarize yourself with these functions as you'll need them frequently. In future branches, we'll cover additional concepts such as polymorphic relationships and pivot tables.

## Note

You can utilize the [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection) to make API calls.

## Resources
- [Laravel Documentation](https://laravel.com/docs/10.x/eloquent-relationships)
- [Eloquent Relationships](https://ralphjsmit.com/laravel-eloquent-relationships)
