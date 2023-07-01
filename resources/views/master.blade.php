<!DOCTYPE html>
<html lang="es">
<head>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado de Pulgas</title>
    <meta name="app-url" content="{{ url('/') }}">
    <meta name="autor" content="LolStore">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Somos una empresa dedicada a la comercialización de productos de entretinimiento">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&amp;display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/faviconfinal.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/iconfonts/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Slick Js -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick/slick-theme.css') }}">

    <link href="{{ asset('assets/vendor/noUiSlider/dist/nouislider.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/drift-main/dist/drift-basic.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/flipdown-master/dist/flipdown.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=2.0') }}">

</head>

<body>
    
    @include('header')

    <main class="main">

        @section('content')
        @show

    </main>

    @include('footer')

    <script src="{{ asset('assets/js/jquery.js') }}"></script>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/slick/slick/slick.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/noUiSlider/dist/nouislider.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/js/scripts.js?v=1.0') }}"></script>
    <script src="{{ asset('assets/js/cart.js?v=1.0') }}"></script>

    @section('scripts')
    @show

</body>