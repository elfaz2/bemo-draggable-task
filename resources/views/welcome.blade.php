<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BeMo Draggable</title>

        <style>
            html{line-height:1.15;-webkit-text-size-adjust:100%}
            body{margin:0}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                width: 100%;
                height: 100vh;
                background-color: #4a5568;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="app">
            <Home/>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
