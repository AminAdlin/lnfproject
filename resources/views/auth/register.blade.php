<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTMFoundIt - Register</title>

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

        .system-title h1::after {
            content: "";
            display: block;
            width: 88px;
            height: 4px;
            background: #b75858;
            margin: 10px auto 0;
            border-radius: 10px;
            box-shadow: 0 0 10px #aa2828;
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
    <style>
        .popup {
            position: fixed;
            inset: 0;
            background: rgba(30,0,0,0.6);
            display:flex;
            justify-content:center;
            align-items:center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .popup-box {
            width: 90%;
            max-width: 420px;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: popIn 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .popup-header {
            background: linear-gradient(135deg, #9c2d2d, #551616);
            padding: 18px;
            text-align: center;
        }

        .popup-header h2 {
            color: white;
            margin: 0;
            font-size: 20px;
            letter-spacing: 2px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

/* BODY */
        .popup-body {
            padding: 25px;
            text-align: center;
        }

        .popup-body p {
            font-size: 18px;
            font-weight: 600;
            color: #5e1c1c;
            margin-bottom: 10px;
        }

        .popup-body small {
            color: #555;
            font-size: 14px;
        }

/* FOOTER */
        .popup-footer {
            padding: 0 25px 25px;
            text-align: center;
        }

        .popup-footer button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #600808;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .popup-footer button:hover {
            background: #4b0000;
        }

/* ANIMATION */
        @keyframes popIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

/* RESPONSIVE */
        @media (max-width: 480px) {
            .popup-body p {
                font-size: 16px;
            }

            .popup-header h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">

    <div class="system-title">
        <h1>UTMFoundIt</h1>
        <p>Lost & Found System</p>
    </div>

    <div class="card shadow p-4 w-100"
    style="max-width: 420px;">

        <h4 class="text-center mb-4">Create Account</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status') == 'verification-sent')
        <div id="popup" class="popup">

            <div class="popup-box">

                <!-- Header -->
                <div class="popup-header">
                    <h2>UTMFoundIt</h2>
                </div>

                <!-- Body -->
                <div class="popup-body">
                    <p>Email Verification Sent</p>
                    <small>Please check your email inbox to verify your account.</small>
                </div>

                <!-- Button -->
                <div class="popup-footer">
                    <button onclick="goLogin()">OK</button>
                </div>

            </div>
        </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                        👁
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                        👁
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">
            Already have an account?
            <a href="/login" style="color:#800000; font-weight:500;">Login</a>
        </p>

    </div>
</div>

<script>
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

function goLogin() {
    window.location.href = "/login";
}
</script>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);

    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>

</body>
</html>