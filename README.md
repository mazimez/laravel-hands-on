# Enhanced Eloquent Relationships

This section introduces Enhanced Eloquent Relationships, demonstrating how to use relationships in a more efficient and database-independent way.

## Description

This section introduces a new feature called `follow` logic, allowing users to follow each other and view their followers and following lists. The toggle logic has also been improved to reduce dependence on the database.

## Files

The following files are included in this project:

- [2023_06_24_105220_create_user_follows_table.php](database/migrations/2023_06_24_105220_create_user_follows_table.php): This migration file creates the `user_follows` table for storing user-to-user follow relationships.
- [UserFollows](app/Models/UserFollows.php): This model represents the follow relationship between users.
- [UserSeeder](database/seeders/UserSeeder.php) and [PostSeeder](database/seeders/PostSeeder.php): These seeders have been updated to include default followers and likes.
- [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php) and [PostController](app/Http/Controllers/Api/v1/PostController.php): These controllers have been updated with optimized code and new functionalities.
- [UserFollowController](app/Http/Controllers/Api/v1/UserFollowController.php): This new controller handles the follow logic.

## Instructions

Follow these instructions to implement the changes and utilize the resources:

1. Create a new table called `user_follows` to store user follow relationships. Use the [UserFollows](app/Models/UserFollows.php) model to define the relationships `followers` and `following` in the [User](app/Models/User.php) model.

2. Update the [UserSeeder](database/seeders/UserSeeder.php) file. Utilize the [sync](https://laravel.com/docs/10.x/eloquent-relationships#syncing-associations) method to establish followers for each user. By using the `belongsToMany` relationship, the `sync` method adds data to the `user_follows` table using an array of follower IDs. To retrieve the array of IDs, use the `inRandomOrder` method on the `User` model to select random users, excluding self-following.

3. Apply the `sync` method to the [PostLike](app/Models/PostLike.php) model as well. Start by establishing a `belongsToMany` relationship in the [Post](app/Models/Post.php) model called `likers`, which provides a list of users who liked a post. In the [UserSeeder](database/seeders/UserSeeder.php), select random users for each post and add them as likers using the `sync` method. This approach eliminates the need to directly use the `PostLike` model. Such tables (models) that store only the IDs of multiple tables are referred to as "pivot" tables, and data can be inserted into them using methods like `sync`. Laravel documentation provides more information on additional methods, such as [sync](https://laravel.com/docs/10.x/eloquent-relationships#updating-belongs-to-relationships).

4. In the [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php), modify the `index` method to utilize the `likers` relationship from the `Post` model. This allows retrieving the list of users who liked a specific post. In the `toggle` method, use Eloquent's [toggle](https://laravel.com/docs/10.x/eloquent-relationships#toggling-associations) method to easily add or remove likes on any `Post`. As shown, this approach requires minimal code to achieve the same functionality.

5. For the follow feature, create a new controller called [UserFollowController](app/Http/Controllers/Api/v1/UserFollowController.php). In this controller, implement two methods that retrieve the list of followers and following for any given `user`. Connect these methods to appropriate routes. Additionally, include a method that allows users to follow or unfollow each other. This method utilizes the `toggle` logic, similar to the likes functionality mentioned earlier. By using Eloquent's [toggle](https://laravel.com/docs/10.x/eloquent-relationships#toggling-associations) method, following and unfollowing users becomes a straightforward process. Note that users are not allowed to follow themselves. This demonstrates an easy way to implement follow-toggle logic in any project.

6. In the [PostController](app/Http/Controllers/Api/v1/PostController.php), modify the `index` method to include the `likers` relationship. Use [withCount](https://laravel.com/docs/10.x/eloquent-relationships#counting-related-models) to display the count of likes for each post. The `withCount` method is one of many techniques that simplify aggregating data from different tables into a single API response. Refer to the Laravel documentation on [aggregation](https://laravel.com/docs/10.x/eloquent-relationships#aggregating-related-models) for more details.

By following this approach, you can reduce redundant code and make your code more reliant on relationships rather than the database. This becomes especially useful when updating the database to implement polymorphic relationships. Furthermore, you can aggregate data from different tables into a single API response.

For simplified API calls, you can utilize the provided [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

Feel free to explore additional methods like `sync` and `toggle` to implement more features. Consider it as a DIY (Do It Yourself) opportunity.

## Note

To simplify API calls, you can utilize the provided [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).
