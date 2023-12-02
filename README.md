# Basic CRUD Operations

CRUD stands for Create, Read, Update, and Delete. In any project or system, CRUD operations are essential for managing resources such as posts, products, blogs, etc. These operations are typically handled through APIs.

## Description

For each CRUD operation, we will have a separate API. Depending on the project's requirements, the number of APIs needed may vary. Additionally, we will explore the concept of pagination to efficiently handle large amounts of data.

## Files

- [PostController.php](app/Http/Controllers/Api/v1/PostController.php): This controller is responsible for handling the CRUD operations.
- [v1.php](routes/api/v1.php): In this file, we define the routes that connect to the controller's methods.
- [PostCreateRequest](app/Http/Requests/Api/v1/PostCreateRequest.php): This request class is used to validate the input data for creating a post.
- [PostUpdateRequest.php](app/Http/Requests/Api/v1/PostUpdateRequest.php): This request class is used to validate the input data for updating a post.

## Instructions

We will be implementing CRUD operations for our Post resource (table).

1. Create the [PostController.php](app/Http/Controllers/Api/v1/PostController.php) using the `--api` flag. This controller already contains pre-built methods such as `index`, `store`, `show`, etc., corresponding to each CRUD operation.

2. Add five new routes to the `posts` group in the [v1.php](routes/api/v1.php) route file. Each route's endpoint should be connected to a specific method in the controller. Note the usage of [route-model-binding](https://laravel.com/docs/10.x/routing#route-model-binding) by passing the `post` variable in the route.

3. Let's start with the `index` method, which retrieves a list of all the posts in the database. Use the [Post.php](app/Models/Post.php) model and employ the [simplePaginate](https://laravel.com/docs/10.x/pagination#simple-pagination) function for pagination. Pagination allows us to divide the posts into smaller chunks that can be returned via the API, as returning all posts at once may take a considerable amount of time.

4. Next, we focus on the `store` method, which adds a new post to the database. First, create the [PostCreateRequest](app/Http/Requests/Api/v1/PostCreateRequest.php) request class to validate the data provided by the API. Take note of how we pass multiple files as an [array](https://laravel.com/docs/5.2/validation#validating-arrays) in the request. After validation, use the `create` method on the model to insert the record into the database. Additionally, we utilize the [FileManager.php](app/Traits/FileManager.php) to store images in the storage.

5. Moving on to the `update` method, which is responsible for updating a post in the database. Here, we also create a request class to validate the input. Note that we haven't handled file updates in this version, but we will address that in future branches.

6. We also have the `show` method, which returns a specific post, and the `destroy` method, which deletes a post. Notice how we directly obtain an instance of the `Post` model from the method's parameter, utilizing [route-model-binding](https://laravel.com/docs/10.x/routing#route-model-binding).

That concludes the basic implementation of CRUD operations in your project. There are still many other concepts we can explore, such as `policies` and `filters`. We will delve into those topics in future branches.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- as you know in this example, we created each route separately and also returning the exact data we get from DB. but Laravel provides things like [api-resource-routes](https://laravel.com/docs/10.x/controllers#api-resource-routes) and [eloquent-resources](https://laravel.com/docs/10.x/eloquent-resources#introduction) that can help you customize things. try to understand and use it.

## Note
You can use the [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection) to call this APIs.


## Resources

- [route-model-binding](https://laravel.com/docs/10.x/routing#route-model-binding).
- [simplePaginate](https://laravel.com/docs/10.x/pagination#simple-pagination)
- [simplePaginate](https://laravel.com/docs/10.x/pagination#simple-pagination)
- [other CRUD example](https://larainfo.com/blogs/laravel-9-rest-api-crud-tutorial-example)
