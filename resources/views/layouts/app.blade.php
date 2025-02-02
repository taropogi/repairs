<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>




    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/times-trans.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v=x{{ Str::random(40) }}" rel="stylesheet">

</head>

<body>


    <div id="app">
    </div>



    <!-- Styles -->
    <script>
        window.laravelData = @json($data);
    </script>
    <script src="{{ asset('js/app.js') }}?v={{ Str::random(40) }}"></script>
</body>

</html>