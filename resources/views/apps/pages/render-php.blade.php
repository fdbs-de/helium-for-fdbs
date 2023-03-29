<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <title>
            {{$title}}

            @if(isset($settings['site.name']))
                – {{$settings['site.name']}}
            @endif
        </title>

        @if(isset($settings['site.description']))
            <meta name="description" content="{{$settings['site.description']}}">
        @endif

        @if(isset($settings['design.favicon']))
            <link rel="icon" href="{{$settings['design.favicon']}}">
        @endif

        @if(isset($settings['design.fonts']))
            <style>{!! $settings['design.fonts'] !!}</style>
        @endif

        @if(isset($settings['design.colors']))
            <style> :root { {{$settings['design.colors']}} } </style>
        @endif
    </head>
    <body>
        {!! $content !!}
    </body>
</html>