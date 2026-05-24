<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt Received</title>
</head>

<body style="margin:0; padding:25px; background:#f5f5f5; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:auto; background:white; border-radius:18px; overflow:hidden; box-shadow:0 5px 20px rgba(0,0,0,0.08);">

    <div style="background:linear-gradient(135deg,#8b4747,#1e0101); padding:20px; text-align:center;">

        <h1 style="color:white; margin:0; font-size:32px; letter-spacing:2px;">
            UTMFoundIt
        </h1>

        <p style="color:#f1dede; margin-top:10px; font-size:14px;">
            Lost & Found System
        </p>

    </div>

    <div style="padding:40px;">

        <h2 style="color:#800000; margin-bottom:20px;">
            Payment Receipt Received
        </h2>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Hello <strong>{{ $claim->item->user->name }}</strong>,
        </p>

        <p style="color:#555; line-height:1.8; font-size:15px;">
            Good news! A claimant has successfully made a payment and uploaded their bank receipt for the item you found. 
        </p>

        <table style="width:100%; border-collapse: collapse; margin:30px 0; font-size:15px;">
    <tr style="background:#fafafa;">
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#666; font-weight:bold; width:35%;">Item Title:</td>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#333;">{{ $claim->item->title }}</td>
    </tr>
    <tr>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#666; font-weight:bold;">Paid By (Claimant):</td>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#333;">{{ $claim->user->name }}</td>
    </tr>
    <tr style="background:#fafafa;">
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#666; font-weight:bold;">Delivery Method:</td>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#333; text-transform: capitalize;">{{ str_replace('_', ' ', $claim->delivery_method) }}</td>
    </tr>
    <tr>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#666; font-weight:bold; vertical-align: top;">Shipping Address:</td>
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#333; line-height: 1.5; background: #fffcf5;">
            {{ $address }}
        </td>
    </tr>
    <tr style="background:#fafafa;">
        <td style="padding:12px 15px; border-bottom:1px solid #eee; color:#666; font-weight:bold;">Payment Status:</td>
        <td style="padding:12px 15px; border-bottom:1px solid #eee;">
            <span style="background:#e6f4ea; color:#137333; padding:5px 12px; border-radius:50px; font-weight:bold; font-size:13px;">
                SUCCESSFULLY PAID
            </span>
        </td>
    </tr>
</table>

        <div style="background:#fff5f5; border-left:4px solid #7b1111; padding:15px; margin:30px 0; border-radius:4px;">
            <p style="margin:0; font-size:14px; color:#555; line-height:1.6;">
                <strong>Notice:</strong> The actual bank receipt uploaded by the claimant has been <strong>attached to this email</strong>. Please review the attachment to verify the payment transaction before releasing the item.
            </p>
        </div>

        <p style="color:#666; line-height:1.7; font-size:14px; margin-top:30px;">
            Thank you for being an honest community member and using UTMFoundIt!
        </p>

    </div>

    <div style="background:#fafafa; padding:20px; text-align:center; border-top:1px solid #eee;">

        <p style="font-size:12px; color:#999; margin:0;">
            © {{ date('Y') }} UTMFoundIt. All rights reserved.
        </p>

    </div>

</div>

</body>
</html>