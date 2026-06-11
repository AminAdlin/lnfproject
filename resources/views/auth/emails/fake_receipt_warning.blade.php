<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake Receipt Warning</title>
</head>

<body style="margin:0; padding:40px; background:#f5f5f5; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:auto; background:white; border-radius:18px; overflow:hidden; box-shadow:0 5px 20px rgba(0,0,0,0.08);">

    <!-- HEADER -->
    <div style="background:linear-gradient(135deg,#8b4747,#1e0101); padding:35px; text-align:center;">

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
            Fake Receipt Warning
        </h2>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Hello {{ $dispute->claim->user->name }},
        </p>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Our administration team has reviewed a dispute related to your recent item claim.
        </p>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            The payment receipt submitted for this claim has been reported as <strong>fake or invalid</strong>. This violates the UTMFoundIt platform guidelines and may affect your future use of the system.
        </p>

        <div style="background:#fff4f4; border-left:5px solid #b91c1c; padding:18px; margin:30px 0;">
            <strong style="color:#b91c1c;">Warning:</strong>
            <p style="margin-top:10px; color:#555;">
                Please ensure that all payment receipts submitted are genuine. Repeated violations may result in restrictions or suspension of your account.
            </p>
        </div>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            If you believe this report was made by mistake, please contact the UTMFoundIt administrator for further clarification.
        </p>

        <div style="text-align:center; margin:40px 0;">
            <a href="{{ url('/') }}"
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
                Visit UTMFoundIt
            </a>
        </div>

        <p style="color:#999; font-size:13px; margin-top:30px;">
            This is an automated email from the UTMFoundIt administration system. Please do not reply directly to this email.
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