@component('mail::message')
<h1>Bestätigen Sie Ihre Email für Ihren FDBS-Account</h1>

Klicken Sie den Knopf um Ihre Email-Adresse zu bestätigen.<br>
<br>
@component('mail::button', ['url' => $url])
Email-Adresse bestätigen
@endcomponent
<br>
Wenn Sie keinen FDBS-Account bei uns erstellt haben, können Sie diese Mail ignorieren.
@endcomponent
