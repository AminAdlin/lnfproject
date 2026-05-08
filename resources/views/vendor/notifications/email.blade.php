<x-mail::message>

{{-- HEADER / LOGO --}}
<div style="text-align:center; margin-bottom:20px;">
<img src="{{ url('images/logo.png') }}" alt="UTMFoundIt Logo" style="width:120px;">

<h1 style="color:#800000; font-family:Arial, sans-serif; margin-top:10px;">
UTMFoundIt
</h1>

<p style="color:#666; font-size:14px;">
Lost & Found System
</p>
</div>

---

{{-- GREETING --}}
@if (! empty($greeting))
# <span style="color:#800000;">{{ $greeting }}</span>
@else
@if ($level === 'error')
# Whoops!
@else
# Hello!
@endif
@endif

---

{{-- INTRO LINES --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

---

{{-- ACTION BUTTON --}}
@isset($actionText)
<?php
    $color = 'primary';
?>

<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>

If the button doesn’t work, copy and paste the link below:

{{ $displayableActionUrl }}

@endisset

---

{{-- OUTRO LINES --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

---

{{-- SALUTATION --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Regards,<br>
<strong style="color:#800000;">UTMFoundIt Team</strong>
@endif

---

{{-- FOOTER --}}
<hr style="margin-top:25px; border:none; border-top:1px solid #eee;">

<p style="font-size:11px; color:#999; text-align:center;">
© {{ date('Y') }} UTMFoundIt. All rights reserved.
</p>

</x-mail::message>