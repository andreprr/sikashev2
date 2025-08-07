// resources/views/emails/verify-email.blade.php

@component('mail::message')
# Email Verification

Click the button below to verify your email address.

@component('mail::button', ['url' => $verificationUrl])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
