<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        <!--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">-->
        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
        <script>
            window.Laravel = {
                csrfToken: "{{ csrf_token() }}"
            }


            window.User = {!! Auth::user() !!}

            window.Language = "{{ config('app.locale') }}"

        </script>
    </head>
    <body>
        <div id="app">


        </div>

        <script type="application/javascript" src="{{mix('js/app.js')}}"></script>
    </body>
</html>
