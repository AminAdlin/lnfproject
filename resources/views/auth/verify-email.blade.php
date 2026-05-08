<h2>Email Verification</h2>

<p>
    We sent a verification link to your email.
    Please check your inbox.
</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Resend Email</button>
</form>