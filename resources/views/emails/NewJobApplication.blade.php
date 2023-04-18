@component('mail::message')
# Neue Bewerbung als {{ $name }}

@foreach($values as $key => $value)
<span>{{ $key }}: <b>{{ $value }}</b></span><br>
@endforeach

<small>
    Gesendet am {{ $date }} um {{ $time }} Uhr
</small>
@endcomponent
