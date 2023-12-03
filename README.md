# Polymorphic Relationship(Part 1)

The concept of a polymorphic relationship allows for a single association between two entities to be connected to multiple other entities, regardless of their types. In simpler terms, it provides an elegant way to establish connections between one primary table (resource) and multiple secondary tables (resources) while utilizing only one additional table to maintain this relationship.

## Description
This guide aims to demonstrate the implementation of a polymorphic relationship in the context of adding a new feature for "post comments." Currently, "posts" can be "LIKED/UNLIKED" by "users," and the goal is to extend this functionality to the comments on these "posts" as well. Traditionally, one might consider creating a separate table, such as `comment_likes`, to handle the likes for comments, but this approach can lead to an excessive number of tables.

To maintain a streamlined database structure and optimize efficiency, we will leverage Laravel's polymorphic relationships. By doing so, we can store the "like" information for different tables, such as `posts` and `post_comments`, without the need to create dedicated tables for each of them.

In this guide, we will address the implementation in two parts. Part 1 will cover the initial setup and configuration of the polymorphic relationship.

## Files

The following files have been updated/added in this branch:

- [2023_07_27_190943_create_likables_table](database/migrations/2023_07_27_190943_create_likables_table.php): This migration adds the new table `likables` to facilitate the polymorphic relationship.
- [Post](app/Models/Post.php) and [PostComment](app/Models/PostComment.php): These models have been updated to utilize the polymorphic relationships.
- [PostCommentController](app/Http/Controllers/Api/v1/PostCommentController.php): The controller has been modified, and new methods have been added to handle likes on comments.
- [v1](routes/api/v1.php): New routes have been added to support likes on comments.
- [PostSeeder](database/seeders/PostSeeder.php): The seeder has been updated to add sample likes to each comment.

## Instructions

Please follow these step-by-step instructions to implement the changes and make use of the available resources:

1. **Migration Setup**: Begin by creating a migration for the table `likables`, which will serve as the central storage for the like information. In this migration, include a `user_id` column for the user table, and utilize the `morphs` method with the `likable` parameter. This method automatically adds two columns, `likable_type` and `likable_id`, with `likable` as the prefix. These columns will be used to store the IDs and types of different tables.

2. **Models Configuration**: Update the [Post](app/Models/Post.php) model by commenting out the existing `likers` relationship and creating a new `likers` relationship. This new relationship should be of type `morphToMany` and should use the `likables` table. While column names for the `likables` table can be explicitly provided, Laravel can handle this automatically. For more details, refer to the [Laravel documentation](https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-polymorphic-relations).

3. **Testing Like Functionality**: After updating the `likers` relationship, test the `post-like-toggle` API. Upon calling this API, check the `likers` table to verify that a new entry has been added with `App\Models\Post` in the `likable_type` column and the respective post's ID in the `likable_id` column. Laravel utilizes the namespace and model name as the type identifier.

4. **Implementing Like for PostComment**: Extend the implementation to include `PostComment` by updating the [PostComment](app/Models/PostComment.php) model. Add the same `likers` relationship used for the `Post` model. Additionally, include a global scope in the `PostComment` model to display the `is_liked` field, indicating whether a comment is liked. This setup now enables the `PostComment` model to support the like feature.

5. **Creating APIs**: Introduce two new routes in [v1](routes/api/v1.php) to handle the `PostComment-like-toggle` API and to list the users who liked a specific `PostComment`. Ensure that the `only_user_allowed` middleware is utilized for the toggle API to restrict access to administrators.

6. **Controller Methods**: Implement the two new API methods in [PostCommentController](app/Http/Controllers/Api/v1/PostCommentController.php). These methods will closely resemble those used in [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php). Utilize the `likers` relationship and the `toggle` method to achieve the desired functionality. Additionally, use the `likers` relationship to display the count of likes for each comment in the `index` method.

7. **Validation of Polymorphic Relationship**: Once the new APIs are ready, call the `postComment-like-toggle` API. Upon examination of the `likables` table, you will notice a new entry with `App\Models\PostComment` in the `likable_type` column and the corresponding comment's ID in the `likable_id` column. Consequently, the `likables` table becomes the sole repository for storing information about likes for both `posts` and `post_comments`. If the need arises to add the like feature to other models, the `likables` table can be effectively utilized, minimizing the need for additional tables.

8. **Updating PostSeeder**: Finally, update [PostSeeder](database/seeders/PostSeeder.php) to include sample likes for each `PostComment`. This step ensures that the database is seeded with relevant data for testing and demonstration purposes.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- here we make our `like` feature generic so it can be used on any resource. try to do this with `comment` as well, meaning comments can be added on any resource like `posts`, `user` or any other resource. it may be a little complicated but that will help you understand the concept in more detail.
- just like `morphToMany` method, we have other methods like `morphTo`, `morphOne` that you should try to use to get more grip on this concept.


## Note
- Please be aware that in Part 2 of this guide, we will proceed to remove [2023_05_14_063015_create_post_likes_table](database/migrations/2023_05_14_063015_create_post_likes_table.php) migration and [PostLike](app/Models/PostLike.php) model since they will no longer be needed due to the successful implementation of the polymorphic relationship.
- also if you have any doubts on `polymorphism` topic or any other topic in this guide, feel free to open a new [discussion](https://github.com/mazimez/laravel-hands-on/discussions) where you can discuss that topic in detail with other developers.

## Reference

For additional information, you may refer to the following resources:

1. [Laravel Documentation for Many To Many (Polymorphic)](https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-polymorphic-relations)
2. [Use Cases for Polymorphic Relationships](https://blog.logrocket.com/polymorphic-relationships-laravel/)
