<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Post From {{ $owner_name }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 20px;">
    <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
        <tr>
            <td style="text-align: center; padding: 20px;">
                <h1>New Post <strong>{{ $post_title }}</strong> is added by {{ $owner_name }}</h1>
                <p>You may like it, please check it out</p>

                <p>Best regards,</p>
                <p>The {{ config('app.name') }} Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
