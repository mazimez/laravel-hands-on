# User Verification

As your project continues to grow and attract more users, ensuring the authenticity of these users becomes paramount. A well-executed user verification process is crucial in preventing the proliferation of fake accounts and inactive users. User verification is a common practice in many applications, including giants like Google, Instagram, and Reddit. This verification typically involves confirming user identities through their email addresses or phone numbers.

## Description

In our system, we employ a dual verification process using both `phone numbers` and `email addresses`. Additionally, we introduce two new badges: `email verification` and `phone number verification`.

Email verification is a straightforward process, as we can send confirmation emails through our system. However, for phone verification, we rely on external SMS services to send verification codes (OTP) for users to confirm their numbers. Several SMS services, such as [Twilio](https://www.twilio.com/en-us), [Sinch](https://www.sinch.com/en-in/products/apis/messaging/sms/), and [2Factor](https://2factor.in/v3/index), are suitable for this purpose. We have chosen to utilize [2Factor](https://2factor.in/v3/index) for our specific use case. To begin, you need to create an account on `2Factor` and obtain an `API-KEY`, which will be used to make API calls. You can find detailed information in their [API documentation](https://2fa.api-docs.io/v1/getting-started-with-2factor-api/enterprise-a2p-messaging-and-otp-solution-provider). Please note that you may need to complete an account verification process with 2Factor, as sending commercial SMS messages involves certain legal requirements. You can refer to [this tutorial video](https://www.youtube.com/watch?v=b9p85Yjr44o&t=614s) for more information. Additionally, you'll need to create a template for your OTP messages.

Once you have gathered all the necessary information, you can call the API, passing your API-KEY and the user's phone number to send the OTP.

## Files

1. [2023_10_14_201955_add_field_otp_to_users_table](database/migrations/2023_10_14_201955_add_field_otp_to_users_table.php), [UserFactory](database/factories/UserFactory.php), and [BadgeSeeder](database/seeders/BadgeSeeder.php): These files have been updated to support user verification.
2. [UserController](app/Http/Controllers/Api/v1/UserController.php) and [TestController](app/Http/Controllers/Api/v1/TestController.php): Controllers have been updated to facilitate user verification.
3. [services](config/services.php): The configuration file has been updated to include information about the `2-factor` service.
4. [SmsManager](app/Traits/SmsManager.php) and [User](app/Models/User.php): A new trait has been added to send OTP and is used as a static method in the model.
5. [WelcomeMail](app/Mail/WelcomeMail.php), [email_verified.blade](resources/views/email_verified.blade.php), and [welcome_mail.blade](resources/views/welcome_mail.blade.php): Email and blade files have been updated for user verification.

## Getting Started

1. We begin by updating our [BadgeSeeder](database/seeders/BadgeSeeder.php) to add two new badges for `phone verification` and `email verification`. Since we are dealing with seeders, we also need to modify our [UserFactory](database/factories/UserFactory.php) to ensure that each user's phone number remains unique. Once a phone number is verified with one user, it should not be reused for any other user. Since our project is considered in production, we need to handle cases of customers sharing the same phone number manually. We update this rule in our [UserController](app/Http/Controllers/Api/v1/UserController.php) within the `store` method and modify our [UserCreateRequest](app/Http/Requests/Api/v1/UserCreateRequest.php) to enforce uniqueness of the `phone_number`. We also update the `update` method to check if a given phone number is not already associated with another user, ensuring a unique phone number for each user.

2. With a focus on verifying users' phone numbers, we create a new migration, [2023_10_14_201955_add_field_otp_to_users_table](database/migrations/2023_10_14_201955_add_field_otp_to_users_table.php). This migration introduces three new fields, `otp`, `is_phone_verified`, and `is_email_verified`, in the `users` table to store user verification information. To proceed with sending text messages, we configure the necessary parameters in our `.env` file and the [services](config/services.php) configuration. We add a new service, `two_factor`, with keys like `api_url` and `api_key`. The values for these keys are obtained from the `.env` file, where we add new variables such as `TWO_FACTOR_API_KEY` and `TWO_FACTOR_TEMPLATE_NAME`. We also include a variable, `IS_OTP_LIVE`, with values `0` and `1` to indicate whether our system should send actual OTPs or fixed sample (FIX) OTPs. This setting is crucial during testing to manage SMS costs.

3. We create a trait, [SmsManager](app/Traits/SmsManager.php), capable of sending SMS (OTP) using 2Factor's APIs. The trait features a method, `sendTwoFactorMessage`, which takes the `phone_number` and OTP to send. In the `2-factor` service, a template for SMS with OTP variables can be created. We pass this `template_name` generated from the `2-factor` service. The trait also allows for the inclusion of the OTP. It's important to note that we statically add `+91` as the country code, as specifying the country code is necessary for sending SMS. In the future, we may update this aspect to request the country code from customers. With the trait ready, we create a test API that utilizes this trait to send a sample OTP to any phone number. The route, `send-otp`, leads to [TestController](app/Http/Controllers/Api/v1/TestController.php) within the `sendOtp` method. If everything is correctly configured, this API should successfully send a message to the specified number.

4. Now that our trait is ready, we can employ it to verify users' phone numbers. Before creating any new API, we add a static method, `sendOtp`, to the [User](app/Models/User.php) model. This method first checks if OTP is enabled according to the `.env` settings. If OTP is enabled, the method utilizes our trait to send OTPs. If it's disabled, a fixed OTP value, such as `1234`, is used. This method can be employed to send OTPs to users. To verify a user, we introduce two new routes, `users/verify-phone` and `users/confirm-phone`. The `verify-phone` route sends an OTP to the user's number and stores this randomly generated OTP in the database for later verification. The `confirm-phone` route verifies this OTP by comparing it with the stored value. Once a user's OTP is verified, a `PHONE_VERIFIED` badge is added to their profile. We also include validations to prevent already verified users from requesting OTPs again. With this, we have successfully verified users' phone numbers, and we can now focus on verifying email addresses.

5. For email verification, Laravel provides a feature to verify users by sending them a verification link via email. You can learn more about this in the [Laravel documentation](https://laravel.com/docs/10.x/verification#introduction). In our example, we implement it slightly differently. Since we already send a "Welcome Email" when new users register, we can update that email and include a verification link. Clicking on this link will verify the user. From there, the user will be taken to a page indicating that their email is verified, and an `EMAIL_VERIFIED` badge will be added to their profile.

6. To prepare the verification URL, we create a route in our [web.php](routes/web.php) file, which will not be an API route but a `web` route since users will access it directly. We create a route like `/email/verify/{hash}` and link it to the [UserController](app/Http/Controllers/Api/v1/UserController.php) with the `verifyEmail` method. This method takes the encrypted user ID from the URL and decrypts it to identify the user. It sets the `is_email_verified` field to 1 and adds the `EMAIL_VERIFIED` badge to the user's profile. The method then displays a static page indicating that the user is verified. We need to send this route as a link in the "Welcome" email.

7. To achieve this, we update our [WelcomeMail](app/Mail/WelcomeMail.php) in the `__construct` method by introducing a new variable, `$link`, which includes the newly created verification route with the encrypted user ID. This `$link` variable is used in our blade file as well. Now, when a user creates an account, the system will send an email with a verification link for account verification. Existing users who didn't receive this link in their "Welcome" emails can be informed manually.

8. This is how you can verify users in your system, either via email, SMS, or a combination of both. The specific verification process may vary based on your project's requirements, which could be more complex than this basic process. In upcoming branches, we will continue to enhance the "Badge system" by introducing more badges.

## DIY (Do It Yourself)

Here are some additional tasks you can undertake:

- as `2-factor`, there are lots of other SMS services that you can use to send OTPs. try to implement other SMS services as well.
- in mail verification, you may not want to send the link in mail and just send OTP in mail(same as SMS) and that's also a good way to verify user. try to implement that way too.

## Additional Notes

- In upcoming branches, we will continue enhancing the "Badge system" by introducing more badges.
- Engage in in-depth discussions with fellow developers by initiating new [discussions](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel email verification](https://laravel.com/docs/10.x/verification)
2. [Laravel OTP verification](https://unitedwebsoft.in/blog/implement-OTP-login-in-laravel-application-project)
