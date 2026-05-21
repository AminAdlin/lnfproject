<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: white; max-width: 600px; margin: 0 auto; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #8b4747, #1e0101); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 3px; }
        .body { padding: 30px; }
        .status-box { border-radius: 10px; padding: 20px; margin: 20px 0; text-align: center; }
        .approved { background-color: #f0fdf4; border: 2px solid #86efac; }
        .rejected { background-color: #fef2f2; border: 2px solid #fca5a5; }
        .status-icon { font-size: 48px; margin-bottom: 10px; }
        .info-box { background-color: #f9f0f0; border-left: 4px solid #8b4747; border-radius: 5px; padding: 15px 20px; margin: 20px 0; }
        .info-box p { margin: 5px 0; font-size: 14px; color: #333; }
        .info-box strong { color: #8b4747; }
        .btn { display: inline-block; background: linear-gradient(135deg, #8b4747, #1e0101); color: white; padding: 12px 30px; border-radius: 25px; text-decoration: none; font-weight: bold; margin-top: 20px; }
        .footer { background-color: #f4f4f4; text-align: center; padding: 15px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UTMFoundIt</h1>
            <p style="margin:5px 0 0; opacity:0.8; font-size:14px;">Lost & Found System</p>
        </div>
        <div class="body">
            <div class="status-box {{ $statusType === 'approved' ? 'approved' : 'rejected' }}">
                <div class="status-icon">{{ $statusType === 'approved' ? '✅' : '❌' }}</div>
                <h2 style="color: {{ $statusType === 'approved' ? '#166534' : '#991b1b' }}; margin:0;">
                    Claim {{ $statusType === 'approved' ? 'Approved' : 'Rejected' }}
                </h2>
            </div>

            <p>Hi <strong>{{ $claim->user->name }}</strong>,</p>

            @if($statusType === 'approved')
                <p>Great news! Your claim for the item below has been <strong style="color:#166534;">approved</strong> by the finder.</p>
            @else
                <p>Unfortunately, your claim for the item below has been <strong style="color:#991b1b;">rejected</strong> by the finder.</p>
            @endif

            <div class="info-box">
                <p><strong>Item:</strong> {{ $claim->item->title }}</p>
                <p><strong>Category:</strong> {{ $claim->item->category }}</p>
                <p><strong>Location:</strong> {{ $claim->item->location }}</p>
                <p><strong>Recovery Method:</strong> {{ $claim->delivery_method === 'self_pickup' ? 'Self Pickup' : 'Delivery' }}</p>
                <p><strong>Finder Contact:</strong> {{ $claim->item->contact }}</p>
            </div>

            @if($statusType === 'approved')
                @if($claim->delivery_method === 'delivery')
                    <p>Since you chose <strong>Delivery</strong>, please login to complete your payment to proceed.</p>
                @else
                    <p>Since you chose <strong>Self Pickup</strong>, please contact the finder to arrange the pickup.</p>
                    <p><strong>Finder's Contact:</strong> {{ $claim->item->contact }}</p>
                @endif
            @else
                <p>You may browse other found items and submit a new claim if you believe your item is listed.</p>
            @endif
        </div>
        <div class="footer">
            <p>This is an automated message from UTM FoundIt. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} UTM FoundIt — Lost & Found System</p>
        </div>
    </div>
</body>
</html>