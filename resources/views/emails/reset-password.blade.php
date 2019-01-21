@component('mail::message')
# Change Password Request

Click on the bellow button to change password

@component('mail::button', ['url' => 'http://localhost:4200/response-password-reset?token='.$token])
Rest Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
