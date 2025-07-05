@component('mail::message')
# Reset Password Token

Your reset token is: **{{ $token }}**

This token will expire in 10 minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent