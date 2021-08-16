<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <link rel="stylesheet" href="{{ url('css/app.css') }}" />

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        <script src="{{ url('js/app.js') }}"></script>
    </body>
</html>
