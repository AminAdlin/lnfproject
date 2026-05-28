@component('mail::message')
# UTM Foundit Update

@if($status === 'payment_submitted')
Hi, 

The owner has successfully made the postage payment of **RM 10.00** and submitted their shipping details!

**Shipping Address:**
{{ $claim->shipping_address }}

*Note: The payment receipt has been attached to this email for your reference. Please proceed to ship the item as soon as possible.*

@else
{{-- Mesej default untuk status approve/reject sebelum ni --}}
Your claim status has been updated to: **{{ strtoupper($status) }}**.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent