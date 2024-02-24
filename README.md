# LiveWire Part-2

In part-2, we will focus on modularizing our Livewire code to enhance reusability, alongside integrating real-time data validation features.

Livewire can also be used to implement complex logic and UI that handle lots of Data in many forms. in this example we will start with a very basic form and add more features in later branches.

## Description

In part-1, we established a form with fields dynamically updated by the backend in real-time. Now, our objective is to refactor the code for modular reusability, mitigating redundancy and enhancing maintainability.

To initiate this process, let's delve into key configurations. Obtain the Livewire configuration file with the following command:
```
php artisan livewire:publish --config
```
This generates a configuration file [livewire](config/livewire.php) featuring default settings. Notably, the view_path parameter specifies the storage location for Livewire components. Additionally, the temporary_file_upload option governs the handling of uploaded files by Livewire. Further insights can be gleaned from the [Livewire doc](https://livewire.laravel.com/docs/installation#publishing-the-configuration-file).

now we will focus on how we can divide our code to re-use it repeatedly.

## Files

1. [TestController](app/Http/Controllers/Web/TestController.php): updated controller to use new blade file.
2. [livewire](resources/views/layout/livewire.blade.php): new generic blade file for livewire component.
3. [button](resources/views/components/button.blade.php),[error](resources/views/components/error.blade.php),[input](resources/views/components/input.blade.php): added the reusable components.
4. [test-component](resources/views/livewire/test-component.blade.php): updated blade file to use the reusable components.
5. [styles](public/css/styles.css): updated css file and added new classes.


## Getting Started

1. Our primary objective is to enhance the reusability of the code within [test-component](resources/views/livewire/test-component.blade.php). To achieve this, we create a new directory named components under the views folder. This directory will house modular snippets representing different aspects of our primary form, such as `buttons`, `input fields`, and `error messages`.

2. Within the `components` directory, we create files like [button](resources/views/components/button.blade.php), [error](resources/views/components/error.blade.php), [input](resources/views/components/input.blade.php). These snippets can be seamlessly integrated into our main Livewire components to display input fields, buttons, and error messages. Furthermore, the utilization of `wire:loading.class` on `<i>` tags within the input and button components provides visual cues indicating real-time data processing.

3. In [test-component](resources/views/livewire/test-component.blade.php), we incorporate these components using syntax such as `<x-input/>` and `<x-error/>`. The `x-` prefix signifies to Livewire to retrieve code from our components directory for utilization. Additionally, parameters such as `model` and `type` can be passed into these components, facilitating dynamic behavior. This approach significantly streamlines the main Livewire component, rendering it more concise and comprehensible. Further customization options include creating custom components for diverse input types like text areas, dropdowns, and checkboxes.

4. Navigate to [TestController](app/Http/Controllers/Web/TestController.php), where the Livewire component is rendered within a view. Here, we employ a new blade file, [layout/livewire](resources/views/layout/livewire.blade.php). This generic blade file eliminates the need for separate files for each Livewire component, enhancing code organization and maintainability. Additionally, within [TestController](app/Http/Controllers/Web/TestController.php), `TestComponent::getName()` is utilized to retrieve the blade file name for the respective component, simplifying component tracking. These files can be tailored to suit specific project requirements.

5. This encapsulates the process of optimizing the creation and rendering of `Livewire` components, fostering a more generic, rapid, and reusable development approach. Further customization can be undertaken to align with individual project specifications, as the flexibility of Livewire enables tailored solutions while adhering to established standards.

## DIY (Do It Yourself)

Explore additional tasks:

- try to make some re-usable component for different input fields like `drop-down`, `checkbox` etc. you can also try to add file upload option as well.
- learn more about livewire's configuration file to control it much better.

## Additional Notes

- since we are now clear with livewire basic, Part 3 will focus more on how we can use `livewire` to actually fetch and store data into Database. also how we can manage files in it as well.
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).

## Additional Resources

1. [LiveWire Lifecycle](https://livewire.laravel.com/docs/lifecycle-hooks)


