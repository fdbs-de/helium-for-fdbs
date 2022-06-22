@component('mail::message')
# Neue Kontaktanfrage von {{ $name }}

Nachricht:<br>
{{ $message }}

Antworten an:<br>
{{ $email }}
@endcomponent
