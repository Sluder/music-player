<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">

        <title>Music Player</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <h3>Music Player</h3>
                </div>
            </div>
        </nav>

        @yield('content')

        {{-- Scripts --}}
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>

</html>