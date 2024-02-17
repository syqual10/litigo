<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <!-- FAVICONS -->
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon/favicon.png') }}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">
</head>

<body>
    <div id="clouds">
        <div class="cloud x1"></div>
        <div class="cloud x1_5"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>
    <div class='c'>
        @yield('contenido')
    </div>    
</body>
</html>