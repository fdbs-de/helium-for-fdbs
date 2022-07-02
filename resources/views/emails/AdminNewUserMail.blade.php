@component('mail::message')
# Ein neuer Benutzer hat sich registriert

Der Benutzer <b>{{ $email }}</b> hat sich registriert und seine Email bestätigt. Nun wartet er auf eine Freigabe durch einen Administrator.
@endcomponent
