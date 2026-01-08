<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; color: #333;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td style="padding: 30px; text-align: center; color: black;">
                <h2 style="margin: 0;">Welcome to {{ $hostel->name }}</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px;">Hello <strong>{{ $user->name }}</strong>,</p>

                <p style="font-size: 15px;">
                    You have been registered as a <strong>{{ $role->name }}</strong> in our
                    hostel.
                </p>

                <h3 style="margin-top: 30px; font-size: 17px; color: #333;">Login Details:</h3>
                <table cellpadding="5" cellspacing="0" style="font-size: 15px;">
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Password:</strong></td>
                        <td>{{ $password }}</td>
                    </tr>
                </table>

                <p style="margin-top: 30px; font-size: 15px;">
                    Please login and change your password as soon as possible to secure your account.
                </p>

                <p style="margin-top: 40px; font-size: 15px;">
                    Thanks,<br>
                    <strong>Hostel Hub</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 13px; color: #888;">
                This is an automated email. Please do not reply.
            </td>
        </tr>
    </table>

</body>

</html>
