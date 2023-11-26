# Stubs in Laravel

In Laravel, whenever we use commands like `php artisan make:...`, they generate files such as models, migrations, seeders, factories, and more. These files come with default code, and that is made possible through the use of stubs.

## Description

Stubs serve as templates in Laravel, providing a starting point for generating files. They save us time by eliminating the need to write everything from scratch.

Moreover, Laravel allows us to customize these stubs according to our specific needs.

## Files

- [model.stub](stubs/model.stub): Updated model stub file.
- [Post](app/Models/Post.php): Updated model based on the stub.

## Instructions

To access the stub files and customize them, follow these steps:

1. Run the command `php artisan stub:publish` to publish all the stub files. This will create a new folder called `stubs`, which contains all the `.stub` files. You can modify any of these files to match your desired template.

2. Let's focus on the `Model` stub as an example. In this stub, I have made some enhancements. I added default attributes such as `$fillable`, `$hidden`, and `$with`, which are commonly used in our projects. Additionally, I included `public $table = '';` and `public $timestamps = false;`. Feel free to add any template code you need, while ensuring that it does not generate any errors.

3. After updating the stubs according to your requirements, whenever you create files like models, factories, etc., they will be generated based on your customized template. For example, I created the `Post` model, and it was created with our custom template code.

By customizing the stubs, you can align the generated files with your preferred structure and code conventions, making your work more efficient.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- try to add more stubs for things like controller, `observer` and `listeners`
- stubs can also be dynamic based on the parameters you passed while executing the command. try to learn more about it and implement some dynamic stubs into project.


## Resources

- [Laravel Documentation on Stub Customization](https://laravel.com/docs/10.x/artisan#stub-customization)
