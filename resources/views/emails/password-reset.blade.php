{{-- // resources/views/emails/password-reset.blade.php --}}

@component('mail::message')
# Reset Password

Click the button below to reset your password.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
