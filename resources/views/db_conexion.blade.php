@extends('layouts.app')
@section('title', 'BD Conexión')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

{{-- ===================================== --}}

@section('content')
    <h3 style="margin-bottom: 1em;">Estado de Conexión</h3>
    <p style="font-size: 18px">No fue posible conectar a la BD.</p>
@stop
