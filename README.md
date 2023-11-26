# File Seeder

The File Seeder is a Laravel utility that allows efficient management of files within the framework. Creating a Seeder is a recommended approach to adding default images to our system, thereby generating sample data.

## Description

The File Seeder enables the addition of default files, such as Images, Videos, PDFs, etc., to our storage. These files can be used by other Seeders to incorporate representative data.

## Files

-   [public](public): Contains default images to be seeded in the project.
-   [default_images.php](config/default_images.php): Creates a configuration file with a list of image names.
-   [ImageSeeder.php](database/seeders/ImageSeeder.php): Copies files from the Public folder to the storage system.
-   [UserFactory.php](database/factories/UserFactory.php): Utilizes the `default_images` configuration in the factory.

## Instructions

Follow these steps to create a Seeder for Images:

1. Begin by selecting images from the internet and placing them in the `public` folder. These images will serve as the default images. Next, create a configuration file, [default_images.php](config/default_images.php), within the `config` folder. Add the names of all the image files to an array in this configuration file.

2. Proceed to create a Seeder, [ImageSeeder.php](database/seeders/ImageSeeder.php). This Seeder iterates through each image specified in the `default_images` configuration and stores it in our storage system. Ensure that you have `php artisan serve` running and that the `.env` file is correctly configured with the `APP_URL`. Failure to do so may result in Laravel being unable to access the default images. Once you execute the [ImageSeeder.php](database/seeders/ImageSeeder.php), the images will be copied from the [public](public) folder to the [public](storage/app/public/) folder within the `storage` directory. These images can now be utilized by other seeders.

3. Let's utilize the `default_images` to add images to the `profile_image` column in the `users` table. We will utilize the [UserFactory.php](database/factories/UserFactory.php) to incorporate sample data. In this factory, we employ the `default_images` configuration to add the image path to the `profile_image` field. This path can be used to display the image in both web and app interfaces. Further details regarding this functionality will be discussed in subsequent branches.

4. Additionally, include the [ImageSeeder.php](database/seeders/ImageSeeder.php) in our [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php) file, placing it above all other seeders. This ensures that whenever someone seeds the data, they will also receive these default images.

5. You may be wondering why we can't simply copy the images directly to the `storage` folder, eliminating the need for the [ImageSeeder.php](database/seeders/ImageSeeder.php). This is true when using local storage; however, if you transition to a storage service such as `AWS` or `Google Cloud`, direct file copying will not be possible. Therefore, having this Seeder that can perform the copying process for us proves to be beneficial.


## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to do the same things for different type of files like `Videos`, `PDFs`, `Docs`.
- the file seeder we generated uses the existing files in our project. but with [Faker](https://github.com/fzaninotto/Faker) Library and Laravel `factory`, you can also generate images and use it as well. try to implement this into project.
