@extends('layouts.app')
@section('title', 'Inicio')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="d-flex p-0">
        <div class="p-0" style="width: 15%">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 d-flex flex-column" style="width: 85%">
            @if (isset($alertaTrial))
                <div class="w-100 mt-0 mb-0">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {!! $alertaTrial !!}
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                    </div>
                </div>
            @endif

            <div class="text-end">
                <a class="nav-link text-blue" href="">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="true" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <h2 class="text-uppercase text-center" style="color: #337AB7">storedimo</h2>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="w-100 d-lg-flex justify-content-between mt-5">
                <div class="col-12 col-lg-6 border border-1 rounded me-lg-1" style="height:10rem">
                    <div class="d-flex text-white p-2" style="background-color: #337AB7; height: 90%">
                        <div class="col-6">
                            <h2 class="m-0" style="font-size: 3em"><i class="fa fa-usd"></i> {{ number_format($ventaDiaMes->ventasDia ?? 0, 0, ',', '.') }}</h2>
                            <h3 class="m-0" style="font-size: 1em">Ventas Día</h3>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0">Ventas Mes</h5>
                            <h5 class="m-0">{{ number_format($ventaDiaMes->ventasMes ?? 0, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="p-0 m-0" style="height: 10%"></div>
                </div>
                {{-- ======================================================================= --}}
                <div class="col-12 col-lg-6 border border-1 rounded me-lg-1" style="height:10rem">
                    <div class="d-flex text-white p-2" style="background-color: #3CB371; height: 90%">
                        <div class="col-6">
                            <h2 class="m-0" style="font-size: 3em"><i class="fa fa-shopping-cart"></i> {{ number_format($entradaDiaMes->entradasDia ?? 0, 0, ',', '.') }}</h2>
                            <h3 class="m-0" style="font-size: 1em">Entradas Día</h3>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0">Entradas Mes</h5>
                            <h5 class="m-0">{{ number_format($entradaDiaMes->entradasMes ?? 0, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="p-0 m-0" style="height: 10%"></div>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            {{-- <div class="w-100 d-lg-flex justify-content-between mt-5">
                <div class="col-12 col-lg-6 border border-1 rounded ms-lg-1 mt-3 mt-lg-0" style="height:10rem">
                    <div class="d-flex text-white p-2" style="background-color: #3CB371; height: 90%">
                        <div class="col-6">
                            <h2 class="m-0" style="font-size: 4em"><i class="fa fa-credit-card"></i> 0</h2>
                            <h3 class="m-0" style="font-size: 1em">Ventas Día</h3>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0">Créditos</h5>
                            <h5 class="m-0">0</h5>
                        </div>
                    </div>
                    <div class="p-0 m-0" style="height: 10%"></div>
                </div>
                
                <div class="col-12 col-lg-6 border border-1 rounded ms-lg-1 mt-3 mt-lg-0" style="height:10rem">
                    <div class="d-flex text-white p-2" style="background-color: #337AB7; height: 90%">
                        <div class="col-6">
                            <h2 class="m-0" style="font-size: 4em"><i class="fa fa-money"></i> 1</h2>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0">Préstamos</h5>
                            <h5 class="m-0">1</h5>
                        </div>
                    </div>
                    <div class="p-0 m-0" style="height: 10%"></div>
                </div>
            </div> --}}
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {
            // $("#username").trigger('focus');
        });
    </script>
@stop


