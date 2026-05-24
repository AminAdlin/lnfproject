<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Dispatched</title>
</head>
<body style="margin:0; padding:30px 15px; background-color:#f5f5f5; font-family:Arial, sans-serif;">

    <div style="max-width:550px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.05); border:1px solid #eef0f2;">
        
        <div style="background: linear-gradient(135deg, #8b4747, #1e0101); padding: 25px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 26px; letter-spacing: 1px; font-weight: bold;">UTMFoundIt</h1>
            <p style="color: #f1dede; margin: 5px 0 0 0; font-size: 14px;">Item Delivery Status Update</p>
        </div>

        <div style="padding:30px 25px;">
            <p style="font-size:16px; color:#333; margin-top:0;">Hi <strong>{{ $claim->user->name }}</strong>,</p>
            
            <p style="font-size:14px; color:#555; line-height:1.6;">
                Great news! The finder (<strong>{{ $item->user->name }}</strong>) has marked your claimed item as <strong>Dispatched / Returned</strong>. If it was posted via delivery, it should be on its way to you now.
            </p>

            <table style="width:100%; border-collapse: collapse; margin:25px 0; font-size:14px;">
                <tr style="background:#fafafa;">
                    <td style="padding:12px; border-bottom:1px solid #eee; color:#666; font-weight:bold; width:35%;">Item Dispatched:</td>
                    <td style="padding:12px; border-bottom:1px solid #eee; color:#333; font-weight:bold;">{{ $item->title }}</td>
                </tr>
                <tr>
                    <td style="padding:12px; border-bottom:1px solid #eee; color:#666; font-weight:bold;">Delivery Method:</td>
                    <td style="padding:12px; border-bottom:1px solid #eee; color:#333; text-transform: capitalize;">{{ str_replace('_', ' ', $claim->delivery_method) }}</td>
                </tr>
            </table>

            <div style="background: #fffcf5; border-left: 4px solid #b45309; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                <p style="margin:0; font-size:13px; color:#b45309; line-height:1.5; font-weight: bold;">
                    Have you received your item?
                </p>
                <p style="margin:5px 0 0 0; font-size:13px; color:#6b7280; line-height:1.5;">
                    Once the item physically arrives in your hands, please log in to the system and click the <strong>"Item Received"</strong> button on your dashboard or item post to close this case.
                </p>
            </div>

            <div style="text-align: center; margin: 30px 0 10px 0;">
                <a href="{{ url('/dashboard') }}" 
                   style="background: #7b1111; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 10px; font-size: 15px; font-weight: bold; display: inline-block; box-shadow: 0 4px 10px rgba(123,17,17,0.2);">
                    Go to Dashboard & Confirm Receipt
                </a>
            </div>
        </div>

        <div style="background:#fafafa; padding:15px; text-align:center; font-size:12px; color:#999; border-top:1px solid #eee;">
            This is an automated notification from UTMFoundIt system.
        </div>
    </div>

</body>
</html>