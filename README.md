# Datatables

Data tables are essential components for displaying tabular data efficiently, offering features such as sorting, filtering, searching, and pagination. They are commonly utilized in admin panels to present lists of users, posts, blogs, etc. Several libraries excel in providing robust data tables, including [JQuery Datatable](https://datatables.net/), [ag-grid](https://www.ag-grid.com/), and [tabulator](https://tabulator.info/), each catering to distinct use cases.

Notably, Laravel offers [laravel-datatables](https://yajrabox.com/docs/laravel-datatables/10.0), seamlessly integrated with Laravel 10.

In this example, we opt for [JQuery Datatable](https://datatables.net/) due to its ease of implementation and alignment with our basic requirements.

## Description

In this section, our focus encompasses two primary objectives. Firstly, the development of a Dashboard page to provide an overview of the system's metrics, such as user and post counts. Secondly, the creation of a User List page to display all users, leveraging the capabilities of [JQuery Datatable](https://datatables.net/) to enable searching, sorting, and pagination functionalities.

Consider exploring alternative datatable libraries for implementing the user list.

## Files

1. [DashboardController](app/Http/Controllers/Web/DashboardController.php) and [UserController](app/Http/Controllers/Api/v1/UserController.php): Updates made to the controllers to include metric counts and user list display.
2. [main](resources/views/UI/base/main.blade.php): Imports necessary JavaScript and CSS libraries for datatables.
3. [home](resources/views/UI/home.blade.php) and [users](resources/views/UI/users.blade.php): Blade files updated to incorporate metric counts and the user list display.
4. [web](routes/web.php): Addition of a new route for accessing the user list API.


## Getting Started

1. Before commencing with the `dashboard` setup, modifications are made to the [main](resources/views/UI/base/main.blade.php) blade file, utilizing `@yield` and `@stack` directives to include custom styles (CSS) and scripts (JS). The utility of these methods is demonstrated in the [home](resources/views/UI/home.blade.php) blade file, where `@push` is employed to append custom CSS. This approach, similar to `@include` and `@section`, offers flexibility, allowing multiple `@push` instances to contribute to an existing stack. Additional methods like `@pushIf` and `@prepend` are available, detailed in the [Laravel documentation](https://laravel.com/docs/10.x/blade#stacks). Furthermore, JavaScript and CSS for `jquery.dataTables` are incorporated into [main](resources/views/UI/base/main.blade.php) to facilitate datatable creation in [users](resources/views/UI/users.blade.php).

2. In our [home](resources/views/UI/home.blade.php), after adding custome `css`, we will add `HTML` code to show different counts like `$user_count`, `$active_post_count` etc. all these counts are calculated from [DashboardController](app/Http/Controllers/Web/DashboardController.php) and sent to blade file. in blade file, we just show these counts with some `bootstrap` classes and `icons` from [font-awesome](https://fontawesome.com/). so now our `dashboard` is ready, we can focus on User list.

3. when showing the list of `Users` in admin panel, we need an API to fetch that data. so first we will create a new API(we can't use our existing APIs since that requires Bearer Tokens), now in [UserController](app/Http/Controllers/Web/UserController.php) of `WEB`, we add new method `indexApi` that will return the list of users with `search` and `sorting`. this API will be used in blade file [users](resources/views/UI/users.blade.php)

4. in [users](resources/views/UI/users.blade.php) file, we first add 1 empty `<table>` tag with the ID of `myTable` and class of `display`. this css class is provided by `jquery.dataTables` itself. now in `js` we first prepare an array of `columns` that decides which columns should be shown in our table. here, for image you can see we are using `render` option to actually add the `<img>` tag to show the image. also with `orderable` option you can disable the sorting for any column. now that our `columns` variable is ready, we use `DataTable()` function on our table element to actually render the dataTable.

5. there are lot of configurations for `DataTable()` that let us customize it according to our needs. for example, in `ajax` option, we can provide our `API` route that gives the users list. also there is a option of `dataFilter` and `data` too where `data` helps with sending data about `pagination`, `sorting`, `searching` into API, `dataFilter` helps in formatting the response and rendering the table. you can learn more about `dataFilter` and `data` from [datatables doc](https://datatables.net/examples/server_side/simple.html).

6. there is also other option like `order` and `pageLength` that let's you set some default sorting and per_page limit. the `columns` option takes an array of the columns variable that we created earlier. you can customize all these option according to your needs.

7. so that's how you can show the list of users in admin panel. there are lot of other data-tables libraries that you can use for showing the list of users in admin panel with more customization and control. for our basic example, `Jquery Datable` is enough

## DIY (Do It Yourself)

Explore additional tasks:

- try to customize the data-table and add filters to get only those users who's email is verified. also try to change the look of data-table too, there are lots of `css` classes that you can use(try the [bootstrap](https://datatables.net/examples/styling/bootstrap.html) option)
- try to make a similar data-table for posts with features like filters,sorting, pagination and searching etc.

## Additional Notes

- In next branch, we will focus on adding/updating the data of any user in admin panel. for that we use [LiveWire](https://laravel-livewire.com/) that makes it easy and efficient.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Pros and Cons of DataTables](https://poovarasu.medium.com/pros-cons-in-datatables-ff9a4fa83f17)
2. [Laravel database](https://medium.com/geekculture/implementation-of-datatables-in-laravel-cd284d74bf1c)
