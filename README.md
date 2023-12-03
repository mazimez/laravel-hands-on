# Policies

In Laravel, policies serve as a mechanism to define user access rules, determining which data/resources they can view or modify. They also allow for the inclusion of logical components within the policies themselves.

## Description

While it may seem feasible to handle all user access rules directly within controllers, the intended purpose of controllers is to manage the logical aspects of an application, not user access control. This is where policies come into play.

In our example, each post must undergo verification before users can view it. Additionally, posts can be blocked, and once blocked, they should no longer be visible to any user. We will implement these rules using policies.

Policies will be created for each resource, such as posts, post comments, and post likes. However, it's important to note that the post owner can still view their own post, regardless of whether it is verified or blocked.

It is worth mentioning that these rules can be adjusted based on your specific requirements. This flexibility distinguishes rules from logic—rules are defined by us and do not adhere to a strict right or wrong, whereas logic can introduce errors and varying levels of correctness.

## Files

The following files have been updated/added in this branch:

- [PostPolicy.php](app/Policies/PostPolicy.php) and [UserFollowsPolicy](app/Policies/UserFollowsPolicy.php) along with other policies: These files contain the policy definitions for the corresponding rules.
- [PostController](app/Http/Controllers/Api/v1/PostController.php) and [PostFileController](app/Http/Controllers/Api/v1/PostFileController.php) and other controllers: The controllers have been updated to utilize the policies.

## Instructions

Please follow these instructions to implement the changes and make use of the available resources:

1. Policies are generally created based on the corresponding resource (MODEL). To create a policy for the `Post` model, use the command `php artisan make:policy PostPolicy --model=Post`. Here, the `model=Post` parameter indicates that this policy is for the `Post` model. This command generates the [PostPolicy](app/Policies/PostPolicy.php) file, which contains boilerplate code specific to the `Post` model.

2. Each policy file contains various methods such as `viewAny`, `view`, `create`, `update`, etc. Each method corresponds to a different action/task performed on the model. For example, the `view` method is used when a user wants to see a particular post. Within this method, we define the rules that determine whether a user is allowed to view the specified post. More information about policy methods can be found in the [Laravel documentation](https://laravel.com/docs/10.x/authorization#policy-methods).

3. Each method in the policy file takes a `user` parameter, representing the logged-in user obtained from `AUTH`. Additionally, the `view` method takes another parameter, `post`, which represents the post the user wants to view. Within the method, we first check if the post is verified. If it is not, we then verify if the post belongs to the logged-in user. If it doesn't, we utilize the `deny` function, accompanied by an error message stating that the post is not verified and cannot be viewed. The same principle applies to the `blocked` rule. Finally, we return `true` to indicate that the user is allowed to view the post.

4. To utilize this policy within a controller, in the [PostController](app/Http/Controllers/Api/v1/PostController.php), within the `show` method, we employ the `authorize` function. We specify the name of the policy method we wish to call, in this case, `view`. The second parameter is an array containing the model associated with the policy, in our case, [Post](app/Models/Post.php), along with the post that the user wants to view as the second element. This allows the policy to be invoked with the corresponding post.

5. After calling the `authorize` function, if the policy denies the user, an exception will be thrown, and our [Handler](app/Exceptions/Handler.php) class will display the associated message defined within the policy. This approach enables the separation of rules from logic. We will also use the `update` method to enforce the rule that a post can only be edited by the user who created it.

6. Now, we will create another policy, [PostFilePolicy](app/Policies/PostFilePolicy.php). This policy is intended for the [PostFile](app/Models/PostFile.php) model and focuses on the `delete` method. Within the `delete` method, we receive the `user` as the first parameter and the `postFile` to be deleted as the second parameter. An additional parameter, `post`, representing the post to which the `postFile` belongs, is also included. In this method, we first check if the `user` is the owner of the post. If so, we then verify if the `postFile` belongs to the specified `post`. Finally, we return `true`, or alternatively, use `deny` to display a message when the conditions are not met.

7. To utilize the new policy, in the [PostFileController](app/Http/Controllers/Api/v1/PostFileController.php), within the `destroy` method, we utilize the `authorize` method. This time, we pass both the `postFile` and `post` in the array so that they can be used in the policy. This allows for passing additional data to the policy, if required.

8. Within a policy, it is also possible to create custom methods in addition to the default ones. For example, a new policy, [UserFollowsPolicy](app/Policies/UserFollowsPolicy.php), can be created. In this policy, a `toggle` method is defined, which takes the `user` (obtained from AUTH) as the first parameter and the `user_to_follow` (the user that the logged-in user wants to follow) as the second parameter. In this method, we check whether the IDs of both users are the same, thereby prohibiting a user from following themselves.

9. To use the `toggle` method, navigate to the [UserFollowController](app/Http/Controllers/Api/v1/UserFollowController.php), specifically within the `toggle` method. We use the `authorize` method, specifying the custom method we created in the policy (`toggle`) as the first parameter. In the array, we pass the user to be followed. It's important to note that we only pass a single `user` variable, even though the `toggle` method in the policy expects two users. This is because the first user is fetched from `AUTH` and does not need to be explicitly passed. This illustrates how custom methods can be created within policies and used according to your needs.

By employing policies, we can apply our user rules to the project. Separating rules from logic allows for easier rule updates without interfering with the overall logic. In our case, if any other rules for posts are added,

 we only need to update the policies while keeping the controllers intact.

There are various other ways to apply rules, such as using the `authorize` method provided in requests for each API. However, utilizing policies provides a clearer overview of all rules and their management. You have the freedom to choose among the available options.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- we have added policies to only couple of places, try to apply it in whole project.
- there is also methods like `can` and `cannot` that you can use with `policies`, here is it's [Laravel doc](https://laravel.com/docs/10.x/authorization#authorizing-actions-using-policies). try to use these methods as well.

## Note

Other approaches to applying rules include utilizing middleware or directly using the `Gate` functionality. You can find more details in the [Laravel documentation](https://laravel.com/docs/10.x/authorization#intercepting-gate-checks).

## Reference

1. [Laravel Documentation for Policies](https://laravel.com/docs/10.x/authorization#creating-policies)
2. [Policy and Gates](https://code.tutsplus.com/gates-and-policies-in-laravel--cms-29780t)
3. [Laravel Roles and Permissions](https://laravel-news.com/laravel-gates-policies-guards-explained)
