<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ $hostel ? $hostel->name : 'Our Hostel' }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; color: #333;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 650px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); overflow: hidden;">

        <!-- Header -->
        <tr>
            <td
                style="padding: 30px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h2 style="margin: 0; font-size: 26px;">Welcome to {{ $hostel ? $hostel->name : 'Our Hostel' }}</h2>
                <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;">Your Accommodation Details</p>
            </td>
        </tr>

        <!-- Greeting -->
        <tr>
            <td style="padding: 30px 30px 20px 30px;">
                <p style="font-size: 16px; margin: 0;">Hello <strong>{{ $resident->full_name }}</strong>,</p>
                <p style="font-size: 15px; margin: 15px 0 0 0; line-height: 1.6;">
                    Congratulations! Your resident account has been successfully created. We're excited to have you as
                    part of our hostel community.
                </p>
            </td>
        </tr>

        <!-- Accommodation Details -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <h3
                    style="margin: 0 0 15px 0; font-size: 18px; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                    <span style="margin-right: 8px;">🏠</span>Accommodation Details
                </h3>
                <table cellpadding="8" cellspacing="0"
                    style="width: 100%; font-size: 14px; background-color: #f9f9f9; border-radius: 6px;">
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Hostel:</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">
                            {{ $hostel ? $hostel->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Block:</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">{{ $block->name }}</td>
                    </tr>
                    @if ($floor)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Floor:</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">{{ $floor->floor_label }}</td>
                        </tr>
                    @endif
                    @if ($room)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Room Number:</strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">{{ $room->room_number }}</td>
                        </tr>
                    @endif
                    @if ($bed)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Bed Number:</strong>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">{{ $bed->bed_number }}</td>
                        </tr>
                    @endif
                    @if ($occupancy)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Occupancy
                                    Type:</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">
                                {{ $occupancy->occupancy_type }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 12px;"><strong>Check-in Date:</strong></td>
                        <td style="padding: 12px;">
                            {{ \Carbon\Carbon::parse($resident->check_in_date)->format('F d, Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Login Credentials -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <h3
                    style="margin: 0 0 15px 0; font-size: 18px; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                    <span style="margin-right: 8px;">🔐</span>Login Credentials
                </h3>
                <table cellpadding="8" cellspacing="0"
                    style="width: 100%; font-size: 14px; border-radius: 6px; border: 1px solid #000000;">
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #000000;"><strong>Email:</strong></td>
                        <td style="padding: 12px; border-bottom: 1px solid #000000;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;"><strong>Password:</strong></td>
                        <td
                            style="padding: 12px; font-family: 'Courier New', monospace; background-color: #fff; padding: 8px; border-radius: 4px;">
                            {{ $password }}</td>
                    </tr>
                </table>
                <p
                    style="margin: 15px 0 0 0; font-size: 13px; color: #856404; background-color: #fff3cd; padding: 12px; border-radius: 6px; border-left: 4px solid #ffc107;">
                    <strong>⚠️ Important:</strong> Please login and change your password immediately to secure your
                    account. Keep your credentials safe and do not share them with anyone.
                </p>
            </td>
        </tr>

        <!-- Contact Information -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <h3
                    style="margin: 0 0 15px 0; font-size: 18px; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                    <span style="margin-right: 8px;">📞</span>Your Contact Information
                </h3>
                <table cellpadding="8" cellspacing="0"
                    style="width: 100%; font-size: 14px; background-color: #f9f9f9; border-radius: 6px;">
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>Contact Number:</strong>
                        </td>
                        <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">{{ $resident->contact_number }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;"><strong>Guardian Contact:</strong></td>
                        <td style="padding: 12px;">{{ $resident->guardian_contact }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Important Notes -->
        <tr>
            <td style="padding: 0 30px 30px 30px;">
                <div
                    style="background-color: #e7f3ff; border-left: 4px solid #2196F3; padding: 15px; border-radius: 6px;">
                    <h4 style="margin: 0 0 10px 0; color: #1976D2; font-size: 16px;">📋 Important Notes:</h4>
                    <ul style="margin: 0; padding-left: 20px; font-size: 14px; line-height: 1.8; color: #555;">
                        <li>Keep your login credentials secure</li>
                        <li>Follow all hostel rules and regulations</li>
                        <li>Contact the hostel administration for any queries</li>
                        <li>Maintain cleanliness and respect common areas</li>
                    </ul>
                </div>
            </td>
        </tr>

        <!-- Closing -->
        <tr>
            <td style="padding: 0 30px 30px 30px;">
                <p style="margin: 0; font-size: 15px; line-height: 1.6;">
                    If you have any questions or need assistance, please don't hesitate to contact the hostel
                    administration.
                </p>
                <p style="margin: 20px 0 0 0; font-size: 15px;">
                    Welcome aboard!<br>
                    <strong style="color: #667eea;">{{ $hostel ? $hostel->name : 'Hostel Hub' }} Team</strong>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td
                style="background-color: #f8f9fa; text-align: center; padding: 20px; font-size: 13px; color: #6c757d; border-top: 1px solid #e0e0e0;">
                <p style="margin: 0 0 5px 0;">This is an automated email. Please do not reply.</p>
                <p style="margin: 0; font-size: 12px;">© {{ date('Y') }} Hostel Hub. All rights reserved.</p>
            </td>
        </tr>
    </table>

</body>

</html>
