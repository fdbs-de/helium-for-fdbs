@component('mail::message')
<h1>Bestätigen Sie Ihre Email für Ihren FDBS-Account</h1>

Klicken Sie den Button um Ihre Email-Adresse zu bestätigen.<br>
Sollten Sie nicht angemeldet sein, geben Sie Ihre Zugangsdaten ein, um Ihre Email-Adresse zu bestätigen.
<br>
@component('mail::button', ['url' => $url])
Email-Adresse bestätigen
@endcomponent
<br>
Wenn Sie keinen FDBS-Account bei uns erstellt haben, können Sie diese Mail ignorieren.
@endcomponent
