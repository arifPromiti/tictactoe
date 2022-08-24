<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- CSS -->
        <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Scripts -->
        <script src="{{ asset('assets/js/jQuery3.2.1.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>

        @yield('js')
    </head>
    <body>
        @yield('content')
    </body>
</html>
