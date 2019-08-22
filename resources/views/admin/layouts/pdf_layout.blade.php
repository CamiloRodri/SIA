<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- Bootstrap -->
    <link href="{{ asset('gentella/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Char js -->
    <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <style>


        #graficas {
            text-align: center;
            width: 100%;
            display: block;
            margin: auto;
        }


    </style>
</head>

<body>
<div id="pdf">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="text-left">{{ config('app.name')}}</h4>
                </div>
                <div class="col-xs-6">
                    <h4 class="text-right">{{ date("d-m-Y H:i:s") }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h2 class="text-center">@yield('titulo_documento')</h2>
                </div>
            </div>
            <div class="row" id="graficas">
                <br>
                @yield('contenido_pdf')
            </div>
        </div>

    </div>
</div>


<!-- jQuery -->
<script src="{{ asset('gentella/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('gentella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
@stack('functions')

</body>

</html>