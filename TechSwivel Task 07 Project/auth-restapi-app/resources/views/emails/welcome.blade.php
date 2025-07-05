@component('mail::message')
# Welcome, {{ $user->firstName }} {{ $user->lastName }}!

Thank you for registering on our platform.
We are excited to have you with us. Your account is now active.
Click below to explore the API docs.

@component('mail::button', ['url' => url('/')])
Go to App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
