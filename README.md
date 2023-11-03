# Indexing

An index is a critical data structure that enables efficient record retrieval in a database, similar to how an index in a book allows quick access to specific topics or keywords without the need to scour every page. In the realm of databases, indexing plays a pivotal role in accelerating data retrieval and ensuring query accuracy.

The significance of indexing becomes particularly evident when dealing with large databases, where traditional searches can be time-consuming. By incorporating indexing into our database design, we empower it to manage extensive datasets with finesse, thus optimizing query response times.

## Description

In our pursuit of implementing indexing, we are introducing two notable enhancements to our system. First, we are introducing a new badge that users will receive upon making their first comment on a post. Additionally, we are embarking on the creation of a straightforward web-based login system. The rationale behind this login system will become apparent in the next branch as we delve into 'FCM Notifications.'

With these updates in mind, our primary focus is on the integration of indexing into our database. To gauge the actual impact, we will leverage the 'Telescope' tool integrated into our project. This tool will enable us to compare query performance before and after implementing indexing, providing invaluable insights into the enhancement's efficacy.

To begin this journey, we need to populate our database with a substantial amount of data to create a scenario where retrieving data becomes progressively challenging. Subsequently, we will introduce indexing and measure the improvements it brings.

## Files

1. [2023_10_28_114640_add_indexes_to_posts_table](database/migrations/2023_10_28_114640_add_indexes_to_posts_table.php) and [2023_10_28_121435_add_indexes_to_users_table](database/migrations/2023_10_28_121435_add_indexes_to_users_table.php): Migration files to implement indexing on tables.
2. [BadgeSeeder](database/seeders/BadgeSeeder.php): Seeder file updated to include the new badge in the system.
3. [PostCommentObserver](app/Observers/PostCommentObserver.php): Observer added to assign the new badge for the first comment.
4. [UserController](app/Http/Controllers/Web/UserController.php): New controller to support web-based login.
5. [home.blade](resources/views/auth/home.blade.php) and [login.blade](resources/views/auth/login.blade.php): Blade files added for displaying the login and home pages.
6. [web](routes/web.php): New routes added for web-based login.

## Getting Started

1. Our initial step involves the introduction of the new badge feature. We update the [BadgeSeeder](database/seeders/BadgeSeeder.php) to include a badge for users making their first comment. To implement this, we create the [PostCommentObserver](app/Observers/PostCommentObserver.php) with a 'created' method. This method checks if a user's comment is their first on any post and assigns the new badge accordingly. Notably, we utilize the 'whereColumn' method to exclude comments made by users on their own posts, as these do not count towards the badge.

2. With the new badge in place, our focus shifts to indexing. Initially, we introduce a substantial amount of dummy data into our system to slow down data retrieval. This can be achieved by running the [UserSeeder](database/seeders/UserSeeder.php) and [PostSeeder](database/seeders/PostSeeder.php) multiple times or modifying the seeder files to increase the number of posts and users. Our aim is to have around 5000 posts in our system to create a scenario where data retrieval becomes time-consuming. We observe query times using 'Telescope,' as it provides valuable insights into query performance. here is example of how much time it takes in without indexing: <img src="https://i.ibb.co/VV7FfDG/BEFORE.png" alt="BEFORE" border="0"> as you can see it took more then 200ms just for select query on `posts` table. the more data we add, the more time it will take to search in it.

3. Following the data population, we proceed to implement indexing on our 'posts' table. This indexing is designed to optimize searches on the 'title' and 'description' columns, which are the primary fields used for searches. It is essential to note that adding indexes only to the fields used in searches is crucial to prevent unnecessary database bloat. 

4. Once indexing is implemented, we perform another round of searches and measure query performance using 'Telescope.' The goal is to observe significant improvements in query response times. here is an example of how much time it takes in with indexing: <img src="https://i.ibb.co/c14Wb7c/AFTER.png" alt="AFTER" border="0">. as you can see it makes it much faster then before. this way indexes makes our system quick without changing much code.

5. To further enhance our system's performance, we extend indexing to the 'users' table. This involves adding indexes to columns relevant for searches, such as 'name,' 'phone_number,' and 'email.' Additional user data can be seeded into the database using the [UserSeeder](database/seeders/UserSeeder.php) to evaluate the performance of user-related queries.

6. In parallel, we introduce a web-based login system to our system. This login system serves as a foundation for upcoming branches, so its implementation is pivotal. The '/login' route is introduced to check if a user is already logged in. If not, it provides a login form that sends a 'POST' request to the '/login' route. The [UserController](app/Http/Controllers/Web/UserController.php) handles this request by using 'Auth::attempt()' to log in the user, generating a login token stored as a cookie.

7. The 'home' page features a [home.blade](resources/views/auth/home.blade.php) file, displaying the logged-in user's name and providing a 'Logout' button. This button sends a request to the 'logout' route, managed by the [UserController](app/Http/Controllers/Web/UserController.php). The 'Auth::logout()' method is utilized to invalidate the user's cookies and redirect them to the 'login' page. This web-based login system, while basic, fulfills our requirements for this example and can be further refined if needed.

8. The web-based login system is now operational, enabling users to log in via the '/login' route and access the 'home' page. Both 'ADMIN' and regular 'USER' logins are supported. This login system will be utilized in upcoming branches for testing purposes.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- Implement indexing on other tables, such as 'post_comments' (indexing the 'comment' column) and 'tags' (indexing 'name' and 'color_hex' columns).
- Enhance the web-based login system with improved UI and error handling.
- try to add new badges, such as a 'first like' badge.

## Additional Notes

- In upcoming branches, our web-based login system will play a crucial role in implementing features like 'FCM notifications' and 'payment gateway' integration.
- It is recommended to incorporate indexing on columns used for searches in any new tables added to the system. Consistently applying this indexing practice will optimize query performance.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with the developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources
1. [Powering Up Your Laravel App with Indexing](https://sauvikkundu.medium.com/accelerating-your-database-game-powering-up-your-laravel-app-with-indexing-42f35f3f5a56)
2. [Laravel authentication](https://laravel.com/docs/10.x/authentication)
