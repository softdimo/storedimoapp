<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @yield('css')

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('imagenes/logo_storedimo_fondo.png') }}" type="image/x-icon" width="100"
        height="60">

    <!-- Bootstrap CSS 5.3.2 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.5.3.2.min.css') }}">

    <!-- SELECT2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('select2_4.0.13/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('font-awesome-4.5.0/css/font-awesome.min.css') }}"> {{-- Necesario para el ícono del logout --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.min.css') }}">


    {{-- Sweetalert2 (No necesita jquery para funcionar) --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">

    <!-- Datatable -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"> -->

    <!--  Js -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.19.1.validate.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="{{ asset('js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>


    <!-- Datatable -->
    <!-- <script src="{{ asset('js/datatables.min.js') }}"></script> -->

    <!-- archivo de validaciones genéricas -->
    <script src="{{ asset('js/validations.js') }}"></script>
</head>

<body>
    <div class="page-container">
        @if (Request()->path() == '/' ||
                Request()->path() == 'login' ||
                Request()->path() == 'logout' ||
                Request()->path() == 'recuperar_clave' ||
                Request()->is('recuperar_clave_link*'))
            @include('layouts.topbar_login')
        @else
            @include('layouts.topbar')

            {{-- ================================================= --}}
            {{-- AQUI VA LA ALERTA DE VENCIMIENTO DEL PLAN TRIAL --}}
            {{-- ================================================= --}}
            @if (isset($alertaTrial))
                {{-- Contenedor para centrar y aplicar márgenes si es necesario, usa la clase de Bootstrap que prefieras (ej: container, p-3) --}}
                <div class="container mt-0 mb-0">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {!! $alertaTrial !!}
                        {{-- Botón opcional para que el usuario pueda cerrarla --}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        @endif

        @yield('content')

        @include('layouts.footer')
    </div>
