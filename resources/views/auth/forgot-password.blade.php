<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - UTMFoundIt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #8b4747, #1e0101);
            color: #333;
        }

        .card {
            border-radius: 15px;
        }

        .system-title {
            color: white;
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
            font-size: 14px;
        }

        .btn-primary {
            background-color: #9c3131;
            border: none;
        }

        .btn-primary:hover {
            background-color: #450505;
        }

        .form-control:focus {
            border-color: #963636;
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.25);
        }
    </style>
</head>

<body>

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">

    <div class="system-title">
        <h1>UTMFoundIt</h1>
        <p>Forgot Password</p>
    </div>

    <div class="card shadow p-4 w-100" style="max-width: 420px;">

        <h4 class="text-center mb-4">Forgot Password</h4>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Enter UTM Email" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>

        <p class="text-center mt-3">
            Back to
            <a href="{{ route('login') }}" style="color:#800000; font-weight:500;">Login</a>
        </p>

    </div>
</div>

</body>
</html>