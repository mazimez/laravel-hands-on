# Enhanced Storage Management

Undoubtedly, an efficient storage system is pivotal for the success of any project. As a project expands, managing files within the system becomes increasingly complex, particularly when storing files directly within the project's storage. This section explores the integration of external storage systems, such as AWS or GCP, to streamline file management.

## Description

In this section, we will enhance our storage system by leveraging [AWS S3](https://aws.amazon.com/s3/). Additionally, we are introducing a new feature known as "Badges." These Badges serve as achievements and awards to express our appreciation to users. Initially, we will award a Badge to users when they make their first post, with plans to introduce more Badges in the future.

To implement the Storage Update, you will need an AWS account and an associated S3 bucket. You can follow [this guide](https://laravel-news.com/using-aws-s3-for-laravel-storage) for detailed instructions on setting up an AWS account and creating an S3 bucket.

Once your S3 bucket is ready, you'll need to install a package that facilitates Laravel's integration with S3. The package is [league/flysystem-aws-s3-v3](https://packagist.org/packages/league/flysystem-aws-s3-v3), and you can install it using the following command:
```bash
composer require league/flysystem-aws-s3-v3
```

With this package installed, you'll be well-prepared to store files in AWS S3, requiring only a few configuration adjustments.

## Files

1. [2023_10_11_183523_create_badges_table](database/migrations/2023_10_11_183523_create_badges_table.php), [2023_10_11_190059_create_user_badges_table](database/migrations/2023_10_11_190059_create_user_badges_table.php), and [BadgeSeeder](database/seeders/BadgeSeeder.php): These files have been updated to support the Badge system.
2. [UserBadgeController](app/Http/Controllers/Api/v1/UserBadgeController.php), [Badge](app/Models/Badge.php), and [UserBadge](app/Models/UserBadge.php): These new controllers and models are introduced to handle Badge-related APIs.
3. [PostObserver](app/Observers/PostObserver.php): The observer is updated to award the "badge" when a new post is added.
4. [FileManager](app/Traits/FileManager.php): This trait is updated to handle file uploads from URLs.
5. [filesystems](config/filesystems.php) and [.env.example](.env.example): Configuration files and the `.env` file are adjusted to enable the use of AWS S3.
6. [composer.json](composer.json) and [composer.lock](composer.lock): A new package for AWS S3 is added.

## Getting Started

1. To connect our project with AWS S3, you must update your [.env](.env) file and include variables like `AWS_ACCESS_KEY_ID` and `AWS_SECRET_ACCESS_KEY`. Also, adjust the `FILESYSTEM_DISK` variable to 's3' to signify that Laravel should utilize the S3 bucket instead of local storage. You can refer to [filesystems](config/filesystems.php) for further details, and our [files-management branch](https://github.com/mazimez/laravel-hands-on/tree/files-managment) provides additional insights.

2. With your `.env` file configured and your `config` file updated, any photos or videos uploaded will be stored in the AWS S3 bucket, rather than the local storage of your project. In a production environment, you may need to transfer existing files from local storage to the AWS S3 bucket.

3. We have also addressed the storage of avatar images obtained through social login. Our [FileManager](app/Traits/FileManager.php) has been updated to include a method called `saveFileFromUrl`, enabling storage of files from URLs. This method can be used in our [TestController](app/Http/Controllers/Api/v1/TestController.php) to test the storage of files from different URLs. We also use this functionality in our [UserController](app/Http/Controllers/Api/v1/UserController.php) for social login, facilitating the storage of avatar images from URL into our storage system.

4. With the storage system updated and the social login issue resolved, we can now shift our focus towards implementing the Badge System. We'll start by creating a table called "badges" to store all available badges and another table named "user_badges" to track which user has earned which badge. We have also introduced a polymorphic relationship called "badgeable" to link other resources related to a badge. For instance, when a user earns a "first post" badge, we'll record the ID of the corresponding post in the user's badge record.

5. With our migration ready, we have also updated our seeders. The [BadgeSeeder](database/seeders/BadgeSeeder.php) now adds the "First Spark" badge, which we can award to users. We will also update our system to reward this badge to users.

6. Initially, we will modify the [PostObserver](app/Observers/PostObserver.php) to check if a new post is a user's first post. If it is, we will award the "FIRST_POST" badge to that user using the "badges" relationship in the [Post](app/Models/Post.php) model. Hence, whenever a user adds their first post, they will receive this new badge.

7. We will also introduce an API to display all badges earned by any user. To achieve this, we've created the [UserBadgeController](app/Http/Controllers/Api/v1/UserBadgeController.php) and added an "index" method, returning all badges for a given user. Additionally, we've established the "badges" relationship on the [User](app/Models/User.php) model, connecting this method to a route at "users/{user}/badges."

8. This concludes our current implementation of the "Badge system." In future branches, we plan to expand and introduce more badges.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- now that you know about `AWS-S3` and `Storage` facade, you can try to dive deeper into topics like `Image Compression` and `Image Encryption` etc. this topic requires you to  learn more about `Storage` facade as well as `AWS-S3`. so try to implement these into your project.

## Additional Notes

- In upcoming branches, we will continue enhancing the "Badge system" by introducing more badges.
- You can engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel + GCP Storage](https://www.iankumu.com/blog/laravel-google-cloud-storage/)
2. [Laravel + AWS Storage](https://laravel-news.com/using-aws-s3-for-laravel-storage)
3. [Laravel Storage Management](https://laravel.com/docs/10.x/filesystem)
