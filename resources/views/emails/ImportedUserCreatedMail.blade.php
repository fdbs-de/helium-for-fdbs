@component('mail::message')
<h1>Ihr Kunden-Account beim Fleischer Dienst Braunschweig ist nun ein FDBS-Account.</h1>
<br>
Im Zuge unseres Redesigns haben wir ein neues Kundenlogin erstellt.
So finden Sie demnächst unsere Produktspezifikationen unter: <a href="https://fdbs.de/login">fdbs.de/login</a>.<br>
<br>
Aber nicht nur unsere Seite hat sich geändert.
Da Ihr Passwort verschlüsselt ist, haben wir es beim Umzug auf das neue System zurücksetzen müssen.<br>
<br>
<h2>Ihre neuen Login-Daten</h2>
Email: <b>{{ $email }}</b><br>
Passwort (neu): <b>{{ $password }}</b><br>
<br>
<small>
    Sie können Ihr Passwort natürlich auf Ihr voriges zurückändern,
    indem Sie sich mit dem neuen Passwort anmelden und unter
    <b>Profil > Passwort Ändern</b> Ihr Passwort ändern.
</small>
@endcomponent
