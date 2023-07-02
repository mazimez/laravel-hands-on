# FILE-MANAGEMENT

File management is crucial for project organization. Laravel offers various methods to effectively handle files within your project.

## Description

As projects grow, managing files solely within Laravel's Storage folder becomes challenging. To overcome this, alternative storage systems like AWS S3 or Google Cloud are often utilized to store files.

## Files

- [.env.example](.env.example): Update the `FILESYSTEM_DISK` and `APP_URL` variables according to your requirements.
- [filesystems.php](config/filesystems.php): Configure this file to create a symbolic link.
- [FileManager.php](app/Traits/FileManager.php): Incorporate this trait to manage files.
- [v1.php](routes/api/v1.php): Add a new route for file uploads.
- [TestController.php](app/Http/Controllers/Api/v1/TestController.php): Controller for handling file uploads.

## Instructions

Follow these steps to manage your files effectively:

1. Open the `.env` file and locate the `FILESYSTEM_DISK` variable. This variable determines the storage location for your files. By default, it is set to `local`, but you should update it to `public` for easier accessibility via public URLs. Additionally, update the `APP_URL` variable to reflect the host where your project is running (e.g., `http://127.0.0.1:8000`). This URL will be used to generate public URLs for any images in your project.

2. Once the `.env` file is configured, open [filesystems.php](config/filesystems.php). This file contains the configuration related to file management in your project. Familiarize yourself with its contents (for more information, refer to the Laravel documentation). Pay particular attention to the `links` section at the end of the file. This section is used to create a symbolic link from the `storage` folder to the `public` folder. Since the `public` folder serves as the entry point of your project, all files should be accessible from there. To create the symbolic link, run the following command: `php artisan storage:link`. This will create a symbolic link in the `public` folder, making it appear as though all the files are located there. You can find more information about symbolic links on the internet.

3. more on [filesystems.php](config/filesystems.php) config, if you look into `disk`(above the `links`) these are different options where we can store our files. we have selected `public` for our disk, make sure that `visibility` is set to `public` so the files will be visible to for public view. also make sure that `storage` folder has proper permission else it will create some problems (specially in `Ubuntu` system)

4. With the project now set up to handle files, create a trait called [FileManager.php](app/Traits/FileManager.php). This trait contains two methods: `saveFile` for storing files and `deleteFile` for removing files.

5. To test the file management functionality, create a new API route called `upload-file`. This route should accept a file and save it in storage. Connect this route to [TestController.php](app/Http/Controllers/Api/v1/TestController.php) and utilize the [FileManager.php](app/Traits/FileManager.php) trait to handle the file upload.

6. You can use the [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection) to call this API. After invoking the API, the file should be stored in your `Storage` folder. The API will return a URL for the uploaded file. Open this URL in a browser, and if everything is set up correctly, you should be able to view the uploaded file.

7. We have also included an API for removing uploaded files. To use this API, provide the file path as a parameter. The file path corresponds to the location of the file within your project. You can obtain this path from the URL of the uploaded file. In the URL, the portion following `http://127.0.0.1:8000/storage/` represents the file path.

8. After invoking the API to remove a file, attempting to access the file's URL will result in it not being displayed since it has been deleted.

This is one approach to uploading and deleting files in your Laravel project. There are many other methods available, some of which are explained in the provided resources.

## Resources

- [Laravel Documentation](https://laravel.com/docs/10.x/filesystem#main-content)
- [File Management Example](https://larainfo.com/blogs/laravel-9-rest-api-image-upload-with-validation-example)
