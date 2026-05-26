<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <h2>Hi {{ $item->user->name }},</h2>
    
    <p>Good news! Someone has successfully claimed the item you found: <strong>{{ $item->title }}</strong>.</p>
    
    <p><strong>Claimant Details:</strong></p>
    <ul>
        <li>Name: {{ $claimant->name }}</li>
        <li>Recovery Method: 🏃 Self Pickup</li>
    </ul>

    <p>Since the claimant chose <strong>Self Pickup</strong>, please log into UTM FoundIt and set up an appointment date and location at your original post so the claimant can retrieve their item.</p>

    <p style="margin-top: 30px;">
        <a href="{{ url('/items/'.$item->id) }}" style="background-color: #800000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Go to Original Post
        </a>
    </p>

    <br>
    <p>Thank you for making UTM a better place!<br><strong>UTM FoundIt Team</strong></p>
</body>
</html>