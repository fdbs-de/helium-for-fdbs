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



        <!-- START: Ziggy -->
        {{-- @php
            $ziggyGroups = [];
            $user = auth()->user();
            
            array_push($ziggyGroups, 'static');
            array_push($ziggyGroups, Auth::check() ? 'authenticated' : 'guest');

            if ($user)
            {
                if ($user->can_access_customer_panel) array_push($ziggyGroups, 'customer');
                if ($user->can_access_employee_panel) array_push($ziggyGroups, 'employee');
                if ($user->can_access_admin_panel) array_push($ziggyGroups, 'admin');
            }
        @endphp --}}

        @routes
        <!-- END: Ziggy -->



        <!-- START: Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <!-- END: Scripts -->



        @env('production')
            <!-- START: eTracker Analytics -->
            <script id="_etLoader"
                type="text/plain"
                charset="UTF-8"
                data-cookiecategory="etracker"
                data-block-cookies="true"
                data-respect-dnt="true"
                data-secure-code="4aKHpV"
                src="//code.etracker.com/code/e.js"
                async>
            </script>
            <!-- END: eTracker Analytics -->
        @endenv



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
                data-cc-tools="etracker"
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
