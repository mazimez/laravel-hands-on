# Enhanced CRUD

In this section we see some Enhanced CRUD, highlighting new features and improvements. It also offers instructions on how to implement the changes and utilize the associated resources effectively.

## Description

The Enhanced CRUD project aims to enhance the basic CRUD (Create, Read, Update, Delete) functions by introducing additional functionalities and logic that can be utilized across different projects. The key additions include the ability for users to like posts and update post images (including handling videos), as well as managing data in JSON format.

## Files

The following files are included in this project:

- [2023_05_14_062417_create_posts_table.php](database/migrations/2023_05_14_062417_create_posts_table.php): This migration file adds a new `JSON` type field to the `posts` table.
- [Post](app/Models/Post.php): The `Post` model is updated to include the necessary casting for the new `JSON` field.
- [PostFactory](database/factories/PostFactory.php) and [PostFileFactory](database/factories/PostFileFactory.php): These factory files are updated to populate sample data in the new fields.
- [PostController](app/Http/Controllers/Api/v1/PostController.php): The controller methods are updated to handle files and JSON data.
- [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php): This new controller handles the logic for toggling post likes.

## Instructions

Follow these instructions to implement the changes and utilize the resources in the Enhanced CRUD project:

1. Update the relevant migrations to include additional columns in the `posts` table and the `type` field in the `post_files` table, indicating whether a file is a video or a photo.

2. Modify the [PostFactory](database/factories/PostFactory.php) to include default data in the `meta_data` field. Ensure that the field is cast as an array in the [Post](app/Models/Post.php) model, indicating that it is in JSON format.

3. Include a [VideoSeeder](database/seeders/VideoSeeder.php) to seed sample videos into the database. Update the [PostFileFactory](database/factories/PostFileFactory.php) to handle the `type` field, distinguishing between photos and videos. Additionally, define constants for "PHOTO" and "VIDEO" in the model.

4. In the [PostController](app/Http/Controllers/Api/v1/PostController.php), modify the `store` method. Instead of directly storing files and adding their paths to the database, first check the file type using the `getMimeType` method. This allows you to keep a record of the file type. You can add more types like PDF or DOC as needed.

5. Continuing with the `store` method, since the `posts` table now includes the `meta_data` field, users should have the option to include it in the API request. Update the [PostCreateRequest](app/Http/Requests/Api/v1/PostCreateRequest.php) to include validation for the JSON format of the provided data. In the controller, Laravel automatically converts the `meta_data` into JSON format. To store it, use the `json_decode` method to convert it back to a normal string.

6. The `update` method follows a similar process as `store`. However, when files are provided in the request, delete all existing files associated with the post. This approach replaces the existing files with the new ones. Keep in mind that this may not always be the desired behaviour; it depends on the project's requirements. Alternatively, you can keep the existing files and add new ones.

7. A new API endpoint is added in the [PostFileController](app/Http/Controllers/Api/v1/PostFileController.php) to delete a single file from a post using the `delete` method. With the file and JSON handling now addressed, the focus shifts to implementing the like/unlike feature for posts.

8. To enable the like/unlike feature, an `API` named `toggle` is created, connected to the [PostLikeController](app/Http/Controllers/Api/v1/PostLikeController.php). In the controller, the logic first checks if the authenticated user has already liked the post. If a record exists, it is deleted. If there is no record, a new entry is created, associating the authenticated user's ID with the post's ID. Such toggle-like APIs are commonly used for actions like liking/unliking or upvoting/downvoting.

9. When calling the `toggle` API for the first time, it adds an entry for the authenticated user. Subsequent calls remove that entry. You can apply this concept to other resources as well.

Please note that some additional implementation steps are required for the like feature, such as adding a Boolean indicator in the `Post` list to determine whether the post is liked by the authenticated user. Additionally, files are currently deleted from the database but not from storage. These aspects will be covered in future branches. The current branch focuses on handling various data types (files, JSON) and implementing simple logic (toggle).

## Note

To simplify API calls, you can utilize the provided [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).
