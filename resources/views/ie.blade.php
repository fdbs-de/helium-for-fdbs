<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Zugriff über Internet Explorer erkannt!</title>

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

            if (!detectIEEdge())
            {
                window.location.href = '/'
            }
        </script>
    </head>
    <body>
        <h2>Zugriff über Internet Explorer erkannt!</h2>
        <p>Wir haben gemerkt, dass Sie Internet Explorer verwenden, um auf unsere Seite zuzugreifen.</p>
        <p>Aufgrund von Sicherheitsrisiken erlauben wir keine Zugriffe auf unsere Webseite über den Internet Explorer.</p>
        <p>
            Bitte verwenden Sie einen der folgenden Browser:<br>
            <b>Google Chrome</b>, <b>Mozilla Firefox</b>, <b>Microsoft Edge</b> oder <b>Apple Safari</b>
        </p>
    </body>
    <style>
        body {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 1rem;
            background-color: #f8d7da;
            color: #721c24;
            z-index: 9999;
            font-family: sans-serif;
        }

        body h2 {
            margin-top: 0;
            color: #721c24;
            font-weight: 700;
        }
    </style>
</html>
