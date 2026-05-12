<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified - UTMFoundIt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #8b4747, #1e0101);
            font-family: 'Inter', sans-serif;
        }

        .system-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: 25px;
            font-family: 'Montserrat', sans-serif;
        }

        .system-title h1 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: white;
            text-shadow: 0 2px 10px rgba(0,0,0,0.4);
        }

        .system-title p {
            color: #eee;
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
        }

        .btn-primary {
            background-color: #9c3131;
            border: none;
        }

        .btn-primary:hover {
            background-color: #450505;
        }

        .verified-box {
            animation: popIn 0.3s ease;
        }

        @keyframes popIn {
            from {
                transform: scale(0.85);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">

    <!-- TITLE -->
    <div class="system-title">
        <h1>UTMFoundIt</h1>
        <p>Lost & Found System</p>
    </div>

    <!-- CARD -->
    <div class="card shadow p-4 w-100 text-center verified-box"
         style="max-width: 420px;">

        <div class="success-icon mb-3">
            ✔
        </div>

        <h4 class="mb-2" style="color: #2e7d32; font-weight: 700;">
            Email Verified Successfully
        </h4>

        <p style="color: #555;">
            Your account has been successfully verified.<br>
            You can now return to login page.
        </p>

    </div>

</div>

</body>
</html>