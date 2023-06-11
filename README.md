# Sorting and Searching

Sorting and searching are crucial aspects of any system or project. As data grows larger, it becomes essential to provide effective options for finding the desired information. Failing to do so may result in users abandoning the system or project.

## Description

In Laravel, sorting and searching are primarily handled by Eloquent, although external services like [Meilisearch](https://www.meilisearch.com/) can also be utilized. This documentation will focus on Eloquent.

## Files

- [PostController.php](app/Http/Controllers/Api/v1/PostController.php): Updated the `index` method to support sorting and searching.
- [PostIndexRequest.php](app/Http/Requests/Api/v1/PostIndexRequest.php): Added validation for sorting and searching.
- [default_locations.php](config/default_locations.php): some default locations to use in factory.
- [UserFactory.php](database/factories/UserFactory.php): updated factory to add lat-long data.

## Instructions

To enable sorting and searching options for our Post list API, follow these steps:

1. In the `index` method of [PostController.php](app/Http/Controllers/Api/v1/PostController.php), check if the `search` parameter is present in the request. If it is, utilize the `where` method with `LIKE` to search across different columns of the `posts` table. Adjust this code according to the database you are using (the example focuses on `MySQL`).

2. With the `search` option added, you can call the API and pass any word in the `search` parameter. This word will be searched within the `title` and `description` columns. This same process can be applied to any table with any columns.

3. The previous step covers the basic search functionality. For more advanced and efficient search features, you can utilize the [Laravel Scout](https://laravel.com/docs/10.x/scout) package, which integrates external services like [Algolia](https://www.algolia.com/) and [Meilisearch](https://www.meilisearch.com/). We will cover this topic in future branches.

4. Next, let's focus on sorting. To achieve this, take two parameters: `sort_field` and `sort_order`. These parameters allow sorting the data based on different columns. If no sorting parameters are provided, the default sorting will be the [latest](https://laravel.com/docs/10.x/queries#latest-oldest) option, displaying the newest posts first.

5. The `sort_field` parameter represents the name of the field (column) from the table that the user wants to sort. First, check if the given `sort_field` exists in the `Post` model (table). If it doesn't exist, return an error. If the `sort_field` does exist, use the [orderBy](https://laravel.com/docs/10.x/queries#ordering-grouping-limit-and-offset) method to sort the data accordingly.

6. The `sort_order` parameter determines whether the result should be in ascending or descending order. By default, it is set to `Ascending`. Adjust this parameter according to your requirements.

7. Additionally, a filter named `user_id` has been added, allowing retrieval of posts associated with a specific user.

This documentation covers the basic implementation of Sorting & Searching. Future branches will introduce improvements, and you can also explore the [Laravel Scout](https://laravel.com/docs/10.x/scout) package for further information.


## Bonus
- in addition to filtering and sorting. we will see how you can add some fields into response dynamically. we will take users location and distance as an Example.
- for this, we need to update our `users` table. we will add 2 columns `latitude` and `longitude` into our `users` and we also update  [UserFactory.php](database/factories/UserFactory.php) to add some locations lat-long randomly and also update the `User` model.(you need to run `php artisan migrate:fresh --seed` command to update the table.)
- now that our table is updated, look into [UserController.php](app/Http/Controllers/Api/v1/UserController.php), here we are taking 2 parameters from request `latitude` and `longitude`, if this parameters are provided in request then we use `selectRaw()` method to add 1 field `distance` dynamically into response.
- this fields show the distance between each user's lat-long and the lat-long that's provided in request. we are using some trigonometric function here, but you don't need to fully understand it now. just remember that in will give us distance between 2 lat-longs.
- then we can also put 1 more filter `distance` that will give us users within certain range.
- try to understand this code and improve it(take it as a `HomeWork`)
- using this approach to store lat-long as a `string` in DataBase is not that good. but for our example it doesn't matter much, we will see how we can handle this location data properly in future branches.

## Note

You can utilize the [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection) to make API calls.

## Resources



- [Laravel Scout Documentation](https://laravel.com/docs/10.x/scout)
- [Latest](https://laravel.com/docs/10.x/queries#latest-oldest)
- [OrderBy](https://laravel.com/docs/10.x/queries#ordering-grouping-limit-and-offset)
- [More detailed guide on searching](https://scalablescripts.medium.com/laravel-rest-api-tutorial-custom-pagination-search-sorting-using-mysql-bc6a70426aa5)
