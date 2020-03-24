<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Informacion para la Autoevaluación V4.0</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    @include('public.shared.head')
</head>
<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
<main>
    @include('public.shared.header')
    @yield('content')
    @include('public.shared.footer')
    <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>
@include('public.shared.scripts')
@stack('functions')
</body>
</html>
