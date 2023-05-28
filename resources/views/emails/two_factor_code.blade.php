@component('mail::message')
    # Two-Factor Authentication Code

    Your two-factor authentication code is: {{ $twoFactorCode }}

    This code will expire in 10 minutes.

    If you have not tried to login, ignore this message

    Thank you for using our application!,
    {{ config('app.name') }}
@endcomponent
