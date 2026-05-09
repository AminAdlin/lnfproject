<x-mail::message>

{{-- LOGO --}}
<p style="text-align:center;">
    <img src="{{ url('images/UTMFOUNDIT.png') }}"
        alt="UTMFoundIt Logo"
        style="width:80px;">
</p>

# UTMFoundIt

**Lost & Found System**

---

## Hello 👋

Thank you for registering with **UTMFoundIt**.

Please verify your email address to activate your account.

---

<x-mail::button :url="$actionUrl">
Verify Email Address
</x-mail::button>

---

If the button doesn’t work, copy and paste this link:

{{ $displayableActionUrl }}

---

If you did not create this account, you can safely ignore this email.

---

Regards,  
**UTMFoundIt Team**

---

<p style="text-align:center; font-size:11px; color:#999;">
© {{ date('Y') }} UTMFoundIt. All rights reserved.
</p>

</x-mail::message>