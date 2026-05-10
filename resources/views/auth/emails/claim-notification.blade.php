<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: white;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #8b4747, #1e0101);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 3px;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.8;
            font-size: 14px;
        }
        .body {
            padding: 30px;
        }
        .body h2 {
            color: #8b4747;
            margin-bottom: 10px;
        }
        .info-box {
            background-color: #f9f0f0;
            border-left: 4px solid #8b4747;
            border-radius: 5px;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .info-box strong {
            color: #8b4747;
        }
        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UTMFoundIt</h1>
            <p>Lost & Found System</p>
        </div>
        <div class="body">
            <h2>🔔 Someone Claimed Your Item!</h2>
            <p>Hi <strong>{{ $claim->item->user->name }}</strong>,</p>
            <p>Good news! A claimant has submitted a claim for your found item. Here are the details:</p>

            <div class="info-box">
                <p><strong>Item:</strong> {{ $claim->item->title }}</p>
                <p><strong>Category:</strong> {{ $claim->item->category }}</p>
                <p><strong>Location Found:</strong> {{ $claim->item->location }}</p>
                <p><strong>Claimed by:</strong> {{ $claim->user->name }}</p>
                <p><strong>Claimant Email:</strong> {{ $claim->user->email }}</p>
                <p><strong>Recovery Method:</strong> {{ $claim->delivery_method === 'self_pickup' ? 'Self Pickup' : 'Delivery' }}</p>
                <p><strong>Claimed At:</strong> {{ $claim->created_at->format('d M Y, h:i A') }}</p>
            </div>

            <p>Please login to <strong>UTM FoundIt</strong> to review the claim and arrange the item return.</p>
            <p>If the claim is valid, please coordinate with the claimant using their contact details above.</p>
        </div>
        <div class="footer">
            <p>This is an automated message from UTM FoundIt. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} UTM FoundIt — Lost & Found System</p>
        </div>
    </div>
</body>
</html>