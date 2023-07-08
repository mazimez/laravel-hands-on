Apologies for the misunderstanding. I'll make the necessary updates to the text while keeping the format intact. Here's the revised version:

# Scope and Attributes

In Laravel, scopes are a powerful feature that allows you to define reusable query constraints for your Eloquent models. An attribute refers to a specific property or field of an Eloquent model.

## Description

- In this section, we will utilize scopes and attributes to add Booleans and default filters for our posts and users.
- We are also introducing a feature to verify posts, ensuring that all user-added posts undergo verification before becoming available to other users.
- Additionally, we will implement a post blocking feature to prevent blocked posts from appearing anywhere, regardless of verification status.

## Files

The following files are updated/added in this branch:

- [2023_05_14_062417_create_posts_table.php](database/migrations/2023_05_14_062417_create_posts_table.php): Update the migration file to include new columns like `is_verified` and `is_blocked`.
- [PostFactory](database/factories/PostFactory.php): Update the factory file to generate posts with variations of verified/unverified and blocked/unblocked statuses.
- [AppServiceProvider](app/Providers/AppServiceProvider.php): Update the service provider file to add route-model binding without applying the global scope.
- [Post](app/Models/Post.php): Add global and local scopes to the post model.
- [User](app/Models/UserFollows.php): Add an attribute to indicate whether the user is being followed (`is_following` field).
- [PostController](app/Http/Controllers/Api/v1/PostController.php): Update the controller and utilize the scopes created in the model.

## Instructions

Please follow these instructions to implement the changes and make use of the available resources:

1. Start by adding two new fields, `is_verified` and `is_blocked`, to the `posts` table. These fields will indicate whether a post is verified and whether it is blocked. Make sure to update the seeders to include a mixture of verified/unverified and blocked/unblocked posts.

2. Next, update the [Post](app/Models/Post.php) model by adding a global scope. In the `boot` method of the model, create a [global scope](https://laravel.com/docs/5.7/eloquent#global-scopes) directly. Alternatively, you can create a separate `Scope` and apply it here. The global scope, named `active`, should apply two WHERE conditions to fetch only the posts that are verified and not blocked.

3. After adding the global scope, retrieving the list of posts will only return the posts that are verified and not blocked. However, there may be cases where a user wants to see their own posts, regardless of verification or block status. To handle this, in the [PostController](app/Http/Controllers/Api/v1/PostController.php), check if the user is viewing their own posts in the `index` method. If so, apply the `withoutGlobalScope()` method to remove the 'active' global scope and display all posts belonging to that user.

4. To handle the display of a specific post's details in the `show` method, update the route model binding. Currently, when retrieving the `$post` variable in the `show()` method, the global scope is already applied. However, to exclude it, modify the [AppServiceProvider](app/Providers/AppServiceProvider.php) file. In the `boot` method, bind the `post` variable to the route and utilize `withoutGlobalScope`. This way, whenever the `post` variable is used in routes, the global scope will not be applied. In the `show` method, check if the user is viewing their own post. If it is their own post, allow them to view it even if it is not verified or blocked. Otherwise, display an error message with an explanation.

5. Another way to use scopes is by adding boolean attributes. In our case, we want to add a boolean attribute called `is_liked` to indicate if a post is liked by the logged-in user. To achieve this, add another global scope in the [Post](app/Models/Post.php) model. Use the [withExists](https://laravel.com/docs/10.x/eloquent-relationships#other-aggregate-functions) method to dynamically add an `is_liked` field, fetched via the `likers` relationship created in a previous branch. This global scope will add the `is_like` field to the post model for all the APIs that have been developed. This approach allows for the addition of such boolean attributes without the need to update every API separately.

6. Let's revisit local scopes in the [Post](app/Models/Post.php) model. Here, we will add the `scopeMostLikedFirst` scope, which sorts the posts in descending order based on the number of likes. Since it's a local scope, it won't be applied automatically. To use it, apply the `mostLikedFirst()` method in the [PostController](app/Http/Controllers/Api/v1/PostController.php). This will return the most liked posts first. You can create additional scopes such as sorting posts based on the number of comments or retrieving all unverified or blocked posts. Feel free to customize the scopes as needed to suit your project's requirements.

7. It's important to understand when to use global scopes versus local scopes. While the rules may vary based on requirements, as a general guideline, global scopes should be used when the scope is required extensively throughout the project. However, keep in mind that excessive global scopes can result in increased query complexity and slower data retrieval. Hence, for scopes that are only needed in specific contexts, local scopes are more suitable as they can be selectively applied.

8. Moving on to attributes, they can be used to enhance the [User](app/Models/User.php) model. We've added a boolean attribute named `is_following`, which indicates whether the logged-in user is being followed by other users. To implement this attribute, add the `getIsFollowingAttribute()` method to the model. Inside this method, check the [UserFollows](app/Models/UserFollows.php) model to determine if the logged-in user is being followed by the specified user. To include this attribute in the user model, add it to the `$appends` variable. Once added, all APIs that expose the `User` model will include a new field called `is_following`, which returns `true` if the logged-in user is following the user and `false` otherwise.

9. You may be wondering why global scopes weren't used for attributes. Attempting to use global scopes for this purpose resulted in an infinite loop. As a workaround, we used attributes. A [Stack Overflow question](https://stackoverflow.com/questions/76598897/laravel-global-scope-using-global-scope-on-user-model-with-auth-in-it) has been created to address this issue. If a resolution is found, it will be updated in future branches.

10. Attributes can also be used to format data within your models. For example, you can format dates to a specific format or combine fields like `first_name` and `last_name`. Additionally, attributes support data casting, allowing you to transform values such as `1/0` into `true/false` or cast numeric strings into actual numbers. For more examples and details, refer to the [Reference](Reference) section.

so that how you can use `Scopes` and `Attributes` to manipulate the data in you project, you can get creative with it and can implement many intreating features too. but keep in mind that each new `Scope` or `Attribute` is like 1 extra task Laravel needs to do while fetching your data, and having lots of `Scopes` and `Attributes` can really slow down the system, so use it wisely.

you may have noticed that we added some codes just for access-control or checking is user has access to that post or not, and this can be handled more affectively with the help of `policy` and `middleware`. we will discuss about it in our next branch.

Feel free to explore more about `Scope` and `Attributes` and other topics related to it

## Note

To simplify API calls, you can utilize the provided [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Reference
1. [Laravel doc for scopes](https://laravel.com/docs/5.7/eloquent#query-scopes)
2. [Laravel doc for serialization](https://laravel.com/docs/5.7/eloquent-serialization#introduction)
3. [Local vs Global scopes](https://elishaukpongson.medium.com/laravel-scope-an-introduction-87ec5acc39e#:~:text=Difference%20between%20local%20and%20global,all%20queries%20on%20that%20model.)
4. [What Is Eloquent Serialization?](https://www.youtube.com/watch?v=kJL-kq-LCAA)
