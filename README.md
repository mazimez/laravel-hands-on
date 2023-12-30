# Excel Generation

In the world of system data analysis and smooth data migration, generating Excel files is crucial, just like PDF generation. This process helps keep systems flexible and allows exporting entire datasets for easy migration.

## Description

Laravel(PHP) offers various packages for Excel generation, and one widely used option is `maatwebsite/excel`. To get started, follow the steps below. For detailed guidance, check out the [documentation](https://docs.laravel-excel.com/).

To install the package, run the following command in your terminal:
```bash
composer require maatwebsite/excel
```

After installation, create the configuration file for this package using the following command:
```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

Keep in mind that this package requires PHP extensions like `php_xml` and `php_simplexml` to be enabled. Ensure these extensions are active when moving to a production environment.

## Files
1. [UserController](app/Http/Controllers/Api/v1/UserController.php) and [TestController](app/Http/Controllers/Api/v1/TestController.php): Controllers updated to integrate `maatwebsite/excel` for Excel generation.
2. [test_excel.blade](resources/views/excel_exports/test_excel.blade.php) and [test_excel.blade](resources/views/excel_exports/test_excel.blade.php): Blade files updated for Excel templates.
3. [UserExport](app/Exports/UserExport.php), [TestExportFromView](app/Exports/TestExportFromView.php), [TestExportFromCollection](app/Exports/TestExportFromCollection.php): Export classes added to facilitate data export in Excel format.
4. [composer.json](composer.json) and [excel](config/excel.php): Installation of the new package for Excel generation.

## Getting Started

1. Similar to PDF generation, create a new `test-API` within [TestController](app/Http/Controllers/Api/v1/TestController.php) to generate sample Excel files. Execute this API in a browser or through Postman to obtain the Excel file. There are multiple methods for Excel generation, including using a simple `blade` file or directly retrieving data from a query. The data can be either downloaded as a file or stored in the system's storage.

2. Create [TestExportFromCollection](app/Exports/TestExportFromCollection.php) by executing the command `php artisan make:export TestExportFromCollection`. This allows direct Excel export from a query (collection) without relying on a `blade` file. Additionally, create [TestExportFromView](app/Exports/TestExportFromView.php) to export data from a `blade` file.

3. In [TestExportFromView](app/Exports/TestExportFromView.php), the implementation of the `FromView` interface necessitates the `view` method, returning the view containing the desired `blade` file. [test_excel.blade](resources/views/excel_exports/test_excel.blade.php) contains a table formatting the data into columns with headings. For [TestExportFromCollection](app/Exports/TestExportFromCollection.php), interfaces like `FromCollection` and `WithMapping` require methods such as `collection` (returning a collection object of data for export) and `map` (defining which fields of the collection should be displayed).

4. With both export files ready, utilize them in [TestController](app/Http/Controllers/Api/v1/TestController.php). Extract information from the request regarding the desired Excel format (as `Collection` or with `View`) and whether to download or store the file. If stored, retrieve its `URL` using the `Storage` Facade. If downloaded, execute the API in a browser for direct download or use Postman to obtain the raw string data, providing the option to save it as a file. This outlines the basic process of downloading data in Excel format, with plans to create an API for exporting user data.

5. Add a new route `users/export` in the [users](routes/api/v1/users.php) route file, calling the `excelExport` method in [UserController](app/Http/Controllers/Api/v1/UserController.php). Develop a new export file, [UserExport](app/Exports/UserExport.php), dedicated to exporting user data using a `blade` file.

6. Observe the implementation of interfaces like `FromView`, `WithColumnWidths`, `WithColumnFormatting`, and `WithStyles` in [UserExport](app/Exports/UserExport.php). These interfaces offer extensive customization options for the exported Excel file, including column widths and row background colors. Further details on these interfaces are available in the [documentation](https://docs.laravel-excel.com/).

7. Upon calling the API via Postman, receive raw string data for file saving. Alternatively, store the file in the system's storage and return its `URL`.

## DIY (Do It Yourself)

Explore additional tasks:

- Delve into the [excel](config/excel.php) configuration file to tailor Excel exports to better suit your requirements.
- Refer to the [documentation](https://docs.laravel-excel.com/) to incorporate images into the Excel file and explore queuing options for this exporting task.

## Additional Notes

- The focus has been on exporting data from the database; however, the same package facilitates data import. Future branches will delve into data import, providing an avenue for further exploration.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [laravel-excel documentation](https://docs.laravel-excel.com/3.1/exports/extending.html)
2. [Excel Export example](https://techsolutionstuff.com/post/laravel-10-import-export-csv-and-excel-file)
