# LiveWire Part-3

In part-3, we delve into utilizing Livewire to execute data updates within our database effectively.

Livewire seamlessly manages file uploads as well, although our focus on this will be explored in upcoming branches. For now, our concentration lies solely on storing conventional data into the database.

## Description

since we are already familiar with livewire components, in this section we will update our users list where admin can add new user and also update existing user's info. that option will open either a new empty form or with user's data pre-filled and admin can update user's info.

email of user can not be changed, other data like name and phone number can be changed.

since we already have livewire's reusable components for text fields, this will be much easy and quick to make.

## Files

1. [UserController](app/Http/Controllers/Web/UserController.php): Controller Updated to use new Livewire Component.
2. [CreateEditComponent](app/Http/Livewire/User/CreateEditComponent.php) and [create-edit-component](resources/views/livewire/user/create-edit-component.blade.php): new Livewire component with blade file added.
3. [users](resources/views/UI/users.blade.php): blade file updated to add create and edit buttons.
4. [sidebar](resources/views/UI/base/sidebar.blade.php): sidebar updated to remove the test page.
5. [input](resources/views/components/input.blade.php): input component updated with `@props`.
6. [web](routes/web.php): updated the routes to use new Livewire component.


## Getting Started

1. first we will create a new Livewire Component with command like `php artisan make:livewire User/CreateEditComponent`. notice that it's created under `User` folder, [CreateEditComponent](app/Http/Livewire/User/CreateEditComponent.php) will be used to handle creating and editing the users. we can create similar component for any other resource like `Blog`, `Tag` etc.

2. now we will update [CreateEditComponent](app/Http/Livewire/User/CreateEditComponent.php) where first we take `$user` in `mount` and add some rules for validation. in `storeData` method you can see that we are storing data in our database by calling `save` method on our user. in the blade file for this component [create-edit-component](resources/views/livewire/user/create-edit-component.blade.php), we added all the input field for user's name, email and other data with the reusable components. we also add option that can show the image of user as well.

3. notice that we updated [input](resources/views/components/input.blade.php) and now using `@props` this way we can set some default values as well. for example, we added `isDisabled` that's default value will be false so when we want to make some field disabled we can just pass `isDisabled=1` to make it disabled, otherwise it will stay enabled. you can learn more about this from [livewire-doc](https://livewire.laravel.com/docs/nesting#passing-static-props)

4. now that our component is ready, we can use it. first we will add new route in [web](routes/web.php) as `users/create` that will be used to show the empty form to admin for creating new user. that will connect to [UserController](app/Http/Controllers/Web/UserController.php) in `create` method, here we are passing empty User model's class with `new User`, this can then be used in [CreateEditComponent](app/Http/Livewire/User/CreateEditComponent.php) in `mount` method. we will do similar kind of thing for edit where we add new route `users/{user}/edit` and connects it with `edit` method, but here we will pass the `$user` variable that has an actual data from our database So then admin can update it.

5. now that our routes are also ready, we will just update our [users](resources/views/UI/users.blade.php) blade file where we show user's list. first we will add a new button that takes user to create user page and then we update the list's column and add new column `Action` that show the `edit` button, we are using `replace` method of JavaScript to add the ID of each user for each record. this way each edit button will open a form for that particular user.

6. so if everything is set-up properly, you should be able to see the `create` and `edit` button and be able to create new User and also edit existing users.

## DIY (Do It Yourself)

Explore additional tasks:

- in this part, we only update user's text type data but we also have user's image as well. try to implement image upload option as well.
- create this kinds of list and create/edit form for other resource like `TAGs`.

## Additional Notes

- now we are done with `Livewire` and how we can use it to make simple forms. in next part we will focus on deleting any record and also showing pop-ups. 
- Foster insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).

## Additional Resources

1. [LiveWire CRUD example](https://www.itsolutionstuff.com/post/laravel-livewire-crud-application-tutorialexample.html)


