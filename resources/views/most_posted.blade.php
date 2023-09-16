<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Your Outstanding Contribution!</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 20px;">
    <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
        <tr>
            <td style="text-align: center; padding: 20px;">
                <p>Hi {{ $user->name }},</p>
                <p>You added the most posts this month and we deeply appreciate your contribution on our platform.</p>
                <p>please keep posting new posts.</p>

                <p>Best regards,</p>
                <p>The {{ config('app.name') }} Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
