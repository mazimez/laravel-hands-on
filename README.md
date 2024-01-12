# Caching

Caching stands out as a pivotal technique in optimizing system performance. It involves strategically storing data in easily accessible locations, reducing the need for direct database queries. The primary objective is to enhance system speed by retrieving information from cache rather than the database, particularly in scenarios where data remains constant over time.

However, it is crucial not to overly rely on caching, as it serves to expedite system processes rather than replace the original data source. Careful consideration must be given to ensuring cache data aligns with the corresponding database records, preventing discrepancies that may lead to outdated or inaccurate information.

## Description

Laravel(PHP) provides a range of methods for implementing caching in your system. Options include storing cache in simple files within the Laravel project or utilizing more advanced solutions such as database or redis. In this example, we employ the file system (local storage) to store cache information. Feel free to explore alternative caching methods to suit your specific requirements.

Our focus here is on leveraging cache to introduce a new feature that tailors content for users based on their specified interests. For instance, if a user expresses interest in posts with tags like php and node, the system should prioritize showing them content aligned with these preferences. To achieve this, we store information about user-tag relationships in both the database and cache, optimizing retrieval speed.

It's noteworthy that cache entries have a defined expiration period, ensuring periodic updates from the database to keep the cache current. You can adjust this duration based on your specific needs.

## Files
1. [2024_01_01_154916_create_user_tags_table](database/migrations/2024_01_01_154916_create_user_tags_table.php): added new migration for user tag.
2. [cache](config/cache.php): config file updated to support caching.
3. [User](app/Models/User.php), [UserTag](app/Models/UserTag.php): added/updated the models to support `userTag` and `cache`.
4. [PostController](app/Http/Controllers/Api/v1/PostController.php), [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php): controllers updated to support `UserTag` and `cache` logic
5. [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php): service provider updated to store cache data in telescope.
6. `other changes made by laravel-pint for formatting`

## Getting Started

1. before implementing cache, we will add our new feature without cache. for that first we need to add new table to store info about user's interests. we will create a new migration [2024_01_01_154916_create_user_tags_table](database/migrations/2024_01_01_154916_create_user_tags_table.php) and also [UserTag](app/Models/UserTag.php) for it.

2. now on [User](app/Models/User.php) model we will add new relationship for `tags` that will give us tags for specific user. also we update our [UserSeeder](database/seeders/UserSeeder.php) so our default user will have 2 tags `PHP` and `node`. now we need to use this new table whenever someone likes any `post`, where we take all the tags connected to that post and sync it with the tags of users(by sync i mean if it's already there then we don't add it again).

3. we need to update our `post-like` API and add our `user-tag` logic there. so we go to [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php) and while we send the like notification, we call the `addTags` method that will `sync` that post's `TAGs` with logged-in user. in that method, we use `syncWithoutDetaching` method that will add any new tags we have provided without removing the existing ones, we can't use `sync` or `attach` method since it doesn't exactly do the thing we want. so we use `syncWithoutDetaching`, you can learn more about it from [Laravel-doc](https://laravel.com/docs/10.x/eloquent-relationships#syncing-associations). you can also see that there is some code about `Cache` under that but we will focus on that later.

4. now, we will use this `UserTag` model while fetching the data about `posts` and give user some posts related to that user's tags. for that we go to [PostController](app/Http/Controllers/Api/v1/PostController.php) and while sorting the posts, if no sorting field is provided then we add our new logic in which we first get the IDs of all the tags of that user (focus on the `without cache` parts) and then use that ids to first get the `count` of those tags from our products, then we put `orderBy` on that count so the post that has tags related to user's tag will come up first. you can test it with our default user by calling post's list API and see that you should get the posts with tags `PHP` and `node` first. so this way our feature of showing posts according to user's interest is ready. now we will focus on using `Cache`.

5. to start using `Cache`, we will first go to [.env](.env), there we update 1 variable `CACHE_DRIVER` and set it's value to be `file` to inform Laravel that we use files to store cache. now we go to [cache](config/cache.php) config, there you can see there is option of `stores` that's an array with different ways you can store data in cache and we are going to use `file`, you can also decide where exactly you want to store your cache here. you can learn more about it from [Laravel-doc](https://laravel.com/docs/10.x/cache)

6. now that our cache system is ready, first we go to our [UserTag](app/Models/UserTag.php), in `addTags` method we use `Cache` Facade to store our cache data. here we store the ids of tags that for each user. the `put` method on cache is used to store the data, it takes string as key so you fetch this data again, we pass a key that's unique for each user(with it's id) and in other parameter we pass it's value, the array of tag-ids of the user. in 3rd parameter we pass the timestamp till which we store this cache data, we pass the date-time of 1 week from now. this way we store the data in cache and whenever this method is called, we update our cache with new tag-ids. you can also check this cache files in your `cache` folder or at the path you can given in you config file.

7. now that our cache is stored, we will use this in our [PostController](app/Http/Controllers/Api/v1/PostController.php). there we will use `remember` method from `Cache` facade to fetch the user-tags data based on user's ID. keep in mind that here we pass 1 parameter at the end as callback so if that user's cache is not stored yet, it will create that cache based on that function. this way we always get the ids of tags no matter the cache is stored or not.

8. now that we get our data from cache, we use it normally without any issue. this will allow us to not fetch the tag-ids again and again while getting the post list. you can also use `Telescope` to compare both ways (with Cache and Without cache). in `Telescope` you can also see the cache data by going at `cache` route, don't forget to update [TelescopeServiceProvider](app/Providers/TelescopeServiceProvider.php) so it also starts storing `cache` data.

9. this way we can use cache to fetch data that's needed more often but don't change frequently. keep in mind that you shouldn't store all the data in cache either, specially not any sensitive info.

## DIY (Do It Yourself)

Explore additional tasks:

- Implement caching at other points in your system.
- Experiment with storing various data types in cache, such as strings, integers, and even files. Refer to the documentation for details.
- Investigate alternative cache storage options like redis or database.

## Additional Notes

- Till now, we have focused on using Laravel to develop APIs. from now on, we go over some topics to use Laravel for Web development too.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel documentation for cache](https://laravel.com/docs/10.x/cache#adding-custom-cache-drivers)
2. [Blog on Cache ](https://medium.com/@noor1yasser9/understanding-caching-in-laravel-b140542f08dd)
