<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @inertiaHead

        <!-- Cookie Consent Tool by Usercentrics -->
        <script type="application/javascript" src="https://app.usercentrics.eu/latest/main.js" id="rMqB9azKr"></script>
        <meta data-privacy-proxy-server = "https://privacy-proxy-server.usercentrics.eu">
        <script type="application/javascript" src="https://privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js"></script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/imf2sid.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@40,300,0,0">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- IE Detect -->
        <script defer>
            function detectIEEdge()
            {
                var ua = window?.navigator?.userAgent

                var msie = ua.indexOf('MSIE ')
                if (msie > 0)
                {
                    // IE 10 or older => return version number
                    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10)
                }

                var trident = ua.indexOf('Trident/')
                if (trident > 0)
                {
                    // IE 11 => return version number
                    var rv = ua.indexOf('rv:')
                    return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10)
                }

                // other browser
                return false
            }

            if (detectIEEdge())
            {
                window.location.href = '/ie'
            }
        </script>
    </head>
    <body>
        @inertia
    </body>
</html>
