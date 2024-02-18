

# LiveWire Part-1

LiveWire is a powerful tool that facilitates the creation of dynamic web pages and components within Laravel applications. Essentially, it offers a seamless integration between the frontend and backend through JavaScript (JS) and CSS libraries. For comprehensive insights into LiveWire, refer to the official documentation [here](https://livewire.laravel.com/). It enables real-time synchronization of forms with databases and supports various JS operations, leveraging libraries such as [AlpineJs](https://alpinejs.dev/) and [Laravel Echo](https://www.npmjs.com/package/laravel-echo).

With a broad spectrum of applications, LiveWire caters to both simple and complex project requirements.

In this example, the LiveWire topic is divided into three parts. In Part 1, we delve into the installation process and explore the concept of components in LiveWire.

## Description

This section aims to develop a web page (form) capable of capturing user input and storing it in a database while maintaining a real-time connection with the backend through LiveWire.

To begin, we install LiveWire using the following command:
```
composer require livewire/livewire
```
This grants us access to LiveWire commands via Artisan, allowing us to create components similar to how we generate models and controllers in Laravel.

For this example, the focus is on real-time data updates using LiveWire, rather than database storage.

## Files

1. [TestController](app/Http/Controllers/Web/TestController.php): New controller to test Livewire.
2. [TestComponent](app/Http/Livewire/TestComponent.php) and [test-component](resources/views/livewire/test-component.blade.php): new file for Livewire component.
3. [livewire_test](resources/views/UI/livewire_test.blade.php): blade file to actually use Livewire component.
4. [composer.json](composer.json), [composer.lock](composer.lock): Composer dependencies for Livewire.
5. [web](routes/web.php) and [sidebar](resources/views/UI/base/sidebar.blade.php): new route and page for Livewire


## Getting Started

1. We create a new component using the command `php artisan make:livewire TestComponent`. This command generates two files: [TestComponent](app/Http/Livewire/TestComponent.php) and [test-component](resources/views/livewire/test-component.blade.php). The `TestComponent` represents the form to be built for user input, while the blade file contains the HTML, JS, and CSS code for rendering the form. Both files collaborate to establish a real-time connection.

2. Next, we integrate the blade file into our project to view it in the browser. We create a new route in [web](routes/web.php) such as `/livewire-test`, linking it to [TestController](app/Http/Controllers/Web/TestController.php), which returns the view [livewire_test](resources/views/UI/livewire_test.blade.php). Within this view, we include our `main` blade file for basic UI presentation (e.g., sidebar), followed by `@livewireStyles` and `@livewireScripts` tags, essential for LiveWire functionality. Finally, we embed our [test-component](resources/views/livewire/test-component.blade.php) using `@livewire`.

3. In [TestController](app/Http/Controllers/Web/TestController.php), notice the `data` key containing values such as `name`, `email`, and `number`. This data is passed to [test-component](resources/views/livewire/test-component.blade.php), accessed within its `mount` method—a pivotal entry point for component data.

4. Utilizing the passed data, we populate the form fields. Upon visiting `/livewire-test`, users encounter [test-component](resources/views/livewire/test-component.blade.php), showcasing the form. Observe the `form` tag, incorporating `wire:submit.prevent="storeData"`. This binds the form submission to the `storeData` method in [TestComponent](app/Http/Livewire/TestComponent.php), facilitating real-time data storage without page refresh.

5. [TestComponent](app/Http/Livewire/TestComponent.php) includes a `rules` method for form validation, akin to Laravel's request validations. Additionally, the `updated` method triggers on any form field modification, enforcing real-time validation and error display via `@error` tags in the blade file.

6. Two buttons are included in the blade file—one with `type="submit"` and the other with `wire:click="showData"`. The `showData` method logs the updated data upon button click. Subsequently, the `storeData` method redirects to the dashboard upon form submission, demonstrating task execution on button click.

7. Thus, LiveWire empowers the creation of forms that update in real-time, eliminating the need for manual form submissions or page refreshes. Further customization options abound, detailed in the [LiveWire documentation](https://livewire.laravel.com/docs/forms).

## DIY (Do It Yourself)

Explore additional tasks:

- Delve into the LiveWire documentation to discover new tags beyond `@livewire`, `@livewireStyles`, and `@livewireScripts`.
- Develop forms for various resources (e.g., Tags, Badges) to enhance LiveWire proficiency.

## Additional Notes

- Part 2 will refine the form creation process in LiveWire, streamlining blade file usage and error handling.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).

## Additional Resources

1. [LiveWire Documentation](https://livewire.laravel.com/docs/quickstart)
2. [Laravel Livewire | Form Example](https://raviyatechnical.medium.com/laravel-livewire-form-example-727a04cb4e75)

---

