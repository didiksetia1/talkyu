<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password - Talkyu</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <tr>
            <td style="padding: 40px 30px; text-align: center; background-color: #B91C1C;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Talkyu</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #1f2937; margin-top: 0;">Reset Password</h2>
                <p style="color: #4b5563; font-size: 15px; line-height: 1.6;">
                    Halo <strong>{{ $user->name }}</strong>,
                </p>
                <p style="color: #4b5563; font-size: 15px; line-height: 1.6;">
                    Kami menerima permintaan untuk reset password akun Anda. Klik tombol di bawah ini untuk mengatur password baru:
                </p>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 20px 0; text-align: center;">
                            <a href="{{ $resetUrl }}" style="display: inline-block; padding: 14px 32px; background-color: #B91C1C; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 15px;">Reset Password</a>
                        </td>
                    </tr>
                </table>
                <p style="color: #4b5563; font-size: 15px; line-height: 1.6;">
                    Atau copy-paste link berikut ke browser Anda:
                </p>
                <p style="color: #B91C1C; font-size: 13px; word-break: break-all;">
                    {{ $resetUrl }}
                </p>
                <p style="color: #9ca3af; font-size: 13px; line-height: 1.6;">
                    Link ini akan expired dalam <strong>60 menit</strong>.
                </p>
                <p style="color: #9ca3af; font-size: 13px; line-height: 1.6;">
                    Jika Anda tidak merasa meminta reset password, abaikan email ini.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 30px; background-color: #f9fafb; text-align: center;">
                <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                    &copy; {{ date('Y') }} Talkyu. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
