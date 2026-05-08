<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - UTMFoundIt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #8b4747, #1e0101);
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .center-box {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .logo {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #800000;
            font-size: 18px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 10px rgba(0,0,0,0.4);
        }

        p {
            font-family: 'Montserrat', sans-serif;
            font-size: 26px;
            font-weight: 600;
            opacity: 0.9;
        } 

        .btn-custom {
            width: 220px;
            margin: 8px;
            border-radius: 30px;
            font-weight: 800;
        }

        .btn-register {
            background-color: #800000;
            color: white;
            border: none;
        }

        .btn-login {
            background-color: white;
            color: #800000;
            border: none;
        }

        .btn-register:hover {
            background-color: #5a0000;
        }

        .btn-login:hover {
            background-color: #e6e6e6;
        }
    </style>
</head>

<body>

<div class="center-box">

    <!-- LOGO -->
    <div class="logo">
        UTM
    </div>

    <!-- TITLE -->
    <h1>Welcome to UTMFoundIt</h1>
    <p>Lost & Found System</p>

    <!-- BUTTONS -->
    <div class="mt-4">
        <a href="{{ route('register') }}" class="btn btn-register btn-custom">Register</a>
        <a href="{{ route('login') }}" class="btn btn-login btn-custom">Login</a>
    </div>

</div>

</body>
</html>
