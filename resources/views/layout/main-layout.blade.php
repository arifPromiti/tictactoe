<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- CSS -->
        <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <style rel="stylesheet">
            .container {
                margin-top: 30px;
            }

            .card{
                padding: 5px;
            }

            .tiles{
                height: 80px;
                width: 80px;
                border: 2px solid #0b2e13;
                text-align: center;
                font-size: 18px;
            }

            .tilece-a{
                display: inline-block;
                text-decoration: none;
            }
        </style>

        <!-- Scripts -->
        <script src="{{ asset('assets/js/jQuery3.2.1.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>

        @yield('js')
    </head>
    <body>
        @yield('content')
    </body>
</html>
