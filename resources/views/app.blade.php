<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="de">
    <head>
        <!-- START: Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @inertiaHead
        <!-- END: Meta -->



        <!-- START: Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <!-- END: Styles -->



        <!-- START: Fonts -->
        <!-- Powered by Bunny Fonts; the GDPR compliant font CDN -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|jetbrains-mono:400,700" rel="stylesheet" />
        <!-- END: Fonts -->


        <!-- START: Ziggy -->
        @routes
        <!-- END: Ziggy -->



        <!-- START: Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <!-- END: Scripts -->



        <!-- START: IE Detect -->
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
        <!-- END: IE Detect -->
    </head>
    <body>
        @inertia

        <a id="cookie-settings-button" href="#" data-cc="c-settings">Cookie Einstellungen</a>
        
        <!-- START: Cookie Consent Tool-->
        <script src="https://app.prive.eu/consent"
                data-cc-tools="youtube"
                data-cc-privacy="https://fdbs.de/datenschutz"
                data-cc-imprint="https://fdbs.de/impressum"
                data-cc-color="#e00047"
                data-cc-theme="system"
                data-cc-language="browser"
                data-cc-non-eu-consent="false">
        </script>
        <!-- END: Cookie Consent Tool-->
    </body>
</html>
