@component('mail::message')
# Password Reset Successful

Hello {{ $user->firstName }},

Your password has been changed successfully. If you did not request this, please contact support immediately.

@component('mail::button', ['url' => config('app.url')])
Login Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
