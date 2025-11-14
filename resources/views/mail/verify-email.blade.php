@component('mail::message')
# Verify Your Email Address

Hello {{ $user->name }},

Your account has been created successfully. Before you can login and access your account, please verify your email address by clicking the button below.

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address
@endcomponent

This verification link will expire in 7 days.

If you did not create an account, no further action is required.

If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:

{{ $verificationUrl }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

