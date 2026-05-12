<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>

<body style="margin:0; padding:25px; background:#f5f5f5; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:auto; background:white; border-radius:18px; overflow:hidden; box-shadow:0 5px 20px rgba(0,0,0,0.08);">

    <!-- HEADER -->
    <div style="background:linear-gradient(135deg,#8b4747,#1e0101); padding:20px; text-align:center;">

        <h1 style="color:white; margin:0; font-size:32px; letter-spacing:2px;">
            UTMFoundIt
        </h1>

        <p style="color:#f1dede; margin-top:10px; font-size:14px;">
            Lost & Found System
        </p>

    </div>

    <!-- BODY -->
    <div style="padding:40px;">

        <h2 style="color:#800000; margin-bottom:20px;">
            Email Verification Required
        </h2>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Hello {{ $user->name }},
        </p>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Thank you for registering with UTMFoundIt.
            Please verify your email address to activate your account.
        </p>

        <!-- BUTTON -->
        <div style="text-align:center; margin:40px 0;">

            <a href="{{ $url }}"
               style="
                    display:inline-block;
                    background:#7b1111;
                    color:white;
                    padding:14px 32px;
                    border-radius:10px;
                    text-decoration:none;
                    font-weight:bold;
                    font-size:15px;
               ">
                Verify Email
            </a>

        </div>

        <p style="color:#666; line-height:1.7; font-size:14px;">
            If you did not create this account, you can ignore this email.
        </p>

        <p style="color:#999; font-size:13px; margin-top:30px;">
            This verification link may expire for security purposes.
        </p>

    </div>

    <!-- FOOTER -->
    <div style="background:#fafafa; padding:20px; text-align:center; border-top:1px solid #eee;">

        <p style="font-size:12px; color:#999; margin:0;">
            © {{ date('Y') }} UTMFoundIt. All rights reserved.
        </p>

    </div>

</div>

</body>
</html>