# SOCIAL-LOGIN

Social login is very common feature in modern application, it uses customer(User) data from some other social media app to login or create an Account into some other system. this makes registration process easy and fast thus attracting more customers.
## Deployment Overview

In This section we will implement Social login feature for our application. generally we can use accounts from many popular applications like `Google`, `Facebook` and even `Github`. the process of integrating any or all of these service is pretty much same. for our case, we will focus only on `Google` since it's very simple and mostly used.

Also in our system, we use `email` as a `unique` identifier for each user. so if there is some user who already has an account with 1 mail and he/she use `Social-login` to get into system, we don't create new account, we just connect it's existing account with that social-account. also, Admin can not use `Social-login`, this feature is only for normal users.

with Social login, we also add 1 more feature for our `Posts`. now user can add some `TAGS` with each post and user can also filter posts based on these tags too. this will allow users to find posts on specific Topic. User can add multiple tags on any posts but `MAX` tag on any post can be 5. user can also add or Remove any TAG with `edit` API as well.

User `can not` add new Tag for now, tags will be added by default and user can only use it with posts. in future we will add feature for User to add new Tags but that Tag also needs to be `verified by Admin` so on one adds any inappropriate Tags(words) into system. 

now that our requirements are clear, we first need to install 1 new Package in order for social login to work. the package is called [socialite](https://laravel.com/docs/10.x/socialite) and it can be used to integrate services like `Facebook`, `Twitter`, `LinkedIn`, `Google`, `GitHub` etc. so install it, run the following command

```
composer require laravel/socialite
```

It's important that you know a little about [OAuth](https://oauth.net/1/) too since we are going to use some of it's concepts too. for Social login. also refer to [Laravel doc for socialite](https://laravel.com/docs/10.x/socialite) for more detailed info

## Files
1. [PostController](app/Http/Controllers/Api/v1/PostController.php), [TagSeeder](database/seeders/TagSeeder.php) and other migrations and factories: updated the controller and migrations with factory and speeders to implement the `TAGs` feature.
2. [services](config/services.php): update the services config file to add google as a service.
3. [UserController](app/Http/Controllers/Api/v1/UserController.php): add the new method to support social login
4. [composer.json](composer.json) and [composer.lock](composer.lock): added new package for social login.

## Getting Started

1. let's first finish `Tag Feature` since it's easy and straightforward. first we make 1 new table `tags` to store all the tags in system. we will also make [TagFactory](database/factories/TagFactory.php) and [TagSeeder](database/seeders/TagSeeder.php) to add some default data into it. also note that in [TagFactory](database/factories/TagFactory.php), we use `unique()` to make sure that same tag won't get added again. now that out `Tag` resource(table) is ready, we just need to connect it with `Post`. we will use `polymorphism` to connect `post` with `tag` since in future, we will use this `Tag` to connect with other resources like `user` and `files` too. so using `polymorphic relationship` will help us connect TAG with any resource we want.

2. once our migrations and models are ready, we will make the tag list API to user can see all the available tags and select which tags he wants with his post. also we will update our `Post create` and `Post update` API to take tag ids and add it with the post as well. keep in mind that maximum tags on 1 post can only be 5. so we will also update our `Post list` API to to search the post by TAGS and also filter by any TAG id as well, thus making it easy to search and filter any post from system. now since our project is deployed, all the posts that are already added wont have any tags with them but users can still edit those posts and add new TAGs

3. Now that our `TAGs` feature is added, we can focus on `Social login`. usually social login use [OAuth](https://oauth.net/1/) to provide user's data by Access-tokens. each service like `Google`, `Facebook` provides there own APIs to implement this [OAuth](https://oauth.net/1/). we don't need to use all these service's `APIs` directly, the `laravel/socialite` package provide us methods that implements all these services. we just need to configure the package properly so it can use those Service's APIs. you can read more about it from [socialite doc](https://laravel.com/docs/10.x/socialite)

4. we are focusing more on google, so it's important to mention that google provide 1 tool that can help us test our `social-login` feature quickly. it's called [OAuth 2.0 Playground](https://developers.google.com/oauthplayground/). so open that link and then you can see that google provides this OAuth service for all of his services like `Google map`, `Google drive` etc. focus on `Google OAuth2 API v2` and select `email` and `profile` option in it. something like shown in below photo
<img src="https://i.ibb.co/njPmL4h/image.png" alt="image" border="0">

5. once you continue(press `Authorize APIs` button), it will prompt you to select any google account just as you have seen in other Applications. once you select any account, it will go back to that page and now it has option like `Exchange Authorization code for tokens` shown in photo below. select that option, then it will give you an `access_token`(shown in another image) this `access_token` is important since we can use this token to fetch the user's info.
<img src="https://i.ibb.co/HtqzqDY/image.png" alt="image" border="0">
<img src="https://i.ibb.co/6vcRTZ8/image.png" alt="image" border="0">

6. now that we have our `access_token`, we can use this into our `API` to get the user's data. open [TestController](app/Http/Controllers/Api/v1/TestController.php), there is new method called `googleLogin` that takes `access_token` from `$request` and then fetch the data using `Socialite`. if you call this API with the token you generated, you will get your google account's information like `email`, `name` and `avatar` etc. so that's how you can get the User's info just by `access_token`. keep in mind that this tokens are short lived and will expires in 10 mins. also notice that while fetching data we use driver as google(`Socialite::driver('google')`), so Socialite knows that it has to get data from `Google`. if you are using some other service then you have to provide that name in `driver` method.

7. now that we have tested our `Social-login` feature, we can now implement it into our system with 1 new API `users/social-login`. now open [UserController](app/Http/Controllers/Api/v1/UserController.php), we have added new method `socialLogin` that first takes `access_token` and `provider` from `$request` and then fetch the data of user, then check if there is already some user with that same `email`. if it is then it will login with that account, else it will create a new `user` with that `email` and login with that new account.

8. so now our users can use their social accounts to directly login into our system. keep in mind that here the `password` field for the user is `NULL`. so those user cannot login with normal `email` & `password`. also while creating new account in `social-login` API, we are not storing user profile-image that we get from `Socialite`. so we will fix this issues in our future branches too, for now our main focus is on `social-login`. also keep in mind that we only implement our social-login for `google`, different services might requires some extra steps to be implemented. you can read more about it from our [Additional Resources](##Additional-Resources) section.

9. Once the `User` is logged-in with `social-login`, he can use our system as an Normal user. he/she might need to update the profile to add `phone-number` and `profile-image` and they also get our `welcome mail` since it's sent via observer so it doesn't matter from where the account is created, they will receive the mail. this is 1 of the `big benefits` of using `Observers`. now currently, our system only take `access-token` and login the user. we don't have any way to generate that `access-tokens`, for that we need to rely on Google's [OAuth 2.0 Playground](https://developers.google.com/oauthplayground/), but we can also generate this `access-tokens` with `Socialite` package too.

10. Generating this `Access token` is usually the part of `front-end`, so we need to have 1 web-page for it and different services(`Google`, `facebook`) has their own way to handle this `token generation`, but generally they follow [OAuth 2.0](https://oauth.net/2/) standards. so, To implement any service like `google`, `facebook` , `github` we first need to get the `client_id` and `client_secret` from them. different service has different way to do this. since we are focusing on google, [here](https://www.positronx.io/laravel-9-socialite-login-with-google-example-tutorial/) is how you can get that data for `Google`. in that blog, focus on the part where you create google-developer account and get the `client-id` and `secret`. once you get your client-credentials you have to add those in your `.env` file. you can name them anything you want but I suggest `GOOGLE_CLIENT_ID` , `GOOGLE_CLIENT_SECRET`. then to use them, go to [services](config/services.php) config file and add google as a service there. this way you can add any other service too.

11. in [web](routes/web.php) route, we have add 2 new routes to handle `google-login` but it doesn't add any new User into system since we are only focusing on `API` part but you can look more into it and implement it for `WEB` part too.

## Additional Notes

- In future branches, we will try to make our `social-login` more fluent that can handle user-avatar-images and also add support for other services like `facebook` and `github` too.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).


## Additional-Resources

1. [Laravel Socialite](https://laravel.com/docs/10.x/socialite)
2. [Social login with Google](https://www.positronx.io/laravel-9-socialite-login-with-google-example-tutorial/)
3. [Social login with facebook](https://www.itsolutionstuff.com/post/laravel-9-socialite-login-with-facebook-account-exampleexample.html)
4. [Social login with APPLE](https://vimeo.com/366353988)


