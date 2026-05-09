<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>

<h2>Registration Successful</h2>

<p>
    Please verify your email through your inbox first.
</p>

@if(auth()->user()->hasVerifiedEmail())

    <a href="{{ route('login') }}">
        <button>OK</button>
    </a>

@else

    <button onclick="showError()">OK</button>

@endif

<script>
function showError() {
    alert("Please verify your email first.");
}
</script>

</body>
</html>