<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 20px;">
    <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
        <tr>
            <td style="text-align: center; padding: 20px;">
                <h1>Welcome to {{ config('app.name') }}</h1>
                <p>Hi <strong>{{ $user->name }}</strong>,</p>
                <p>Welcome to our system! We're excited to have you on board.</p>
                <p>Your phone number: <strong>{{ $user->phone_number }}</strong></p>
                <p>If you have any questions or need assistance, feel free to reach out to us.</p>
                <p>Best regards,</p>
                <p>The {{ config('app.name') }} Team</p>
            </td>
        </tr>
    </table>
</body>
</html>