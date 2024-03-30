# Policies - Laravel 11

This section explain about what's changed in Policies from Laravel 10 to Laravel 11. initially there is not any major changes but there are some methods/functions that's been updated. you can also refer the [Laravel-doc](https://laravel.com/docs/11.x/authorization#creating-policies) for it.

# Description

the main concept of policy is still the same that it uses to define user access rules, determining which data/resources they can view or modify. with `Laravel-11` there are some new approach of how you can use these `Policies`.


# Instructions
- we know how to create a policy with command like `php artisan make:policy PostPolicy --model=Post` and we have couple of policies created with this like [PostCommentPolicy](app/Policies/PostCommentPolicy.php),[PostFilePolicy](app/Policies/PostFilePolicy.php),[PostPolicy](app/Policies/PostPolicy.php) etc.
- now to use this policy in any controller, in `Laravel-10` we used to call `authorize()` like `$this->authorize` but in `Laravel-11` you can't directly call it like this. instead you need use `Gate` facade from Laravel and `authorize` method on it like `Gate::authorize`.
- the parameters we used to pass into `authorize` are same and this will work the same way it used to in `Laravel-10`. `Gate` is actually the correct place to use our policies and you can still use `policies` with `middleware` as well.

# DIY (Do It Yourself)
- go over the new v1 documentation for policies and see what's new and how you can improve use of policies.

## Next branch
 - `coming soon`
