@component('mail::message')
# Client Approval Form For The Hills Champs

Here is the message:

<strong>From: </strong>{{$email}} <br>
<strong>To: </strong>{{$client_email}} <br>

Please Click the below button to ACTIVATE your account!

<x-mail::button :url="$url" color="success">
Approve
</x-mail::button>

Regards,<br>
Noob
@endcomponent