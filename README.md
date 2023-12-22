# PDF Generation

In the realm of software development, the necessity to generate PDFs arises in various scenarios, whether it be for introducing new features or meeting legal requirements. Many systems offer users the ability to export their data into formats like PDF or Excel, and in some cases, the generation of invoice PDFs becomes imperative. This section will guide you through utilizing Laravel for PDF generation.

## Description

Laravel provides several packages to facilitate PDF generation, with one notable option being `barryvdh/laravel-dompdf`. This package is user-friendly and covers the fundamental requirements for PDF generation. In this example, we'll employ this package. Feel free to explore other packages if needed.

To install the package, execute the following command:
```bash
composer require barryvdh/laravel-dompdf
```

After installation, generate the configuration file for this package using the command:
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

Now that the package is installed, we'll use it to generate a PDF for the posts in our system. This PDF, accessible only to administrators, will include comprehensive information about each post, such as its title, description, tags, and images.

## Files
1. [PostController](app/Http/Controllers/Api/v1/PostController.php) and [TestController](app/Http/Controllers/Api/v1/TestController.php): Updated controllers to incorporate `dom-pdf` for PDF generation.
2. [post_pdf.blade](resources/views/pdfs/post_pdf.blade.php) and [test_pdf.blade](resources/views/pdfs/test_pdf.blade.php): Blade files updated for PDF templates.
3. [composer.json](composer.json) and [dompdf](config/dompdf.php): Installation of the new package for PDF generation.

## Getting Started

1. Before delving into the coding aspect, it's essential to note that the `laravel-dompdf` package can generate PDFs based on both blade files and direct HTML data. Additionally, you can download and store the PDFs. Refer to the [dompdf](config/dompdf.php) config file for package configuration options. To begin, we'll test these functionalities in our [TestController](app/Http/Controllers/Api/v1/TestController.php).

2. Introduce a new route for testing PDF generation: `generate-pdf`, handled by [TestController](app/Http/Controllers/Api/v1/TestController.php). This route accepts parameters `input_type`, `data`, and `output_type`. `input_type` determines whether the PDF uses a blade file or HTML data, while `output_type` specifies options like `download`, `stream`, or `raw_data` for returning the PDF as a file or raw data.

3. In the `generatePdf` method, utilize the `Pdf` class and methods like `loadHTML` or `loadView` to load HTML or blade file content. Methods such as `download`, `stream`, and `output` are used to generate, download, or stream the PDF. The `download` method is commonly used to initiate direct downloads.

4. This API, accessible without authentication and utilizing the GET method, can be called directly in a browser or Postman. The PDF response will either be downloaded or visible in the response. The raw data of the PDF can be obtained as a string, typically used for storage.

5. Examine the [test_pdf.blade](resources/views/pdfs/test_pdf.blade.php) view. This typical blade file contains CSS and features the addition of `page-break-after: always;` in the `styles` section for content separation. Images can be embedded in this HTML. With the test API ready, we can now generate a PDF for posts in our system.

6. In the [posts](routes/api/v1/posts.php) route file, add a new route: `posts/:id/download`, restricted to the `only_admin_allowed` middleware to grant access only to administrators. Create the [post_pdf.blade](resources/views/pdfs/post_pdf.blade.php) file for the post PDF design, passing the necessary `$post` data, including tags and files.

7. While displaying post files, consider file types, differentiating between photos and videos. Note the use of `file_path` without a full URL, suitable for local development. In production, use `Storage::url` for the full URL. The example doesn't use `Storage::url` due to its `http` output, while `dom-pdf` requires `https`.

8. With the blade file ready, incorporate it into [PostController](app/Http/Controllers/Api/v1/PostController.php), passing the `$post` variable for PDF generation, and use the `download()` method for PDF download. Further customization of the design is possible, including adjustments to the [dompdf](config/dompdf.php) config file for custom fonts and PDF size.

## DIY (Do It Yourself)

Explore additional tasks:

- Review and update the [dompdf](config/dompdf.php) config for enhanced PDF control.
- Investigate methods to store generated PDFs or send them as email attachments. Refer to [laravel-dompdf's GitHub](https://github.com/barryvdh/laravel-dompdf) for more information.

## Additional Notes

- `dom-pdf` offers numerous features, to be discussed in subsequent branches. Consider exploring other PDF generation packages.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Generate Simple Invoice PDF with Images and CSS](https://laraveldaily.com/post/laravel-dompdf-generate-simple-invoice-pdf-with-images-css)
2. [laravel-dompdf's GitHub](https://github.com/barryvdh/laravel-dompdf)
