@extends('layouts.app')
@section('title', 'Crear Planes')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')

@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 content-container">
            <div class="d-flex justify-content-between pe-3 mt-3">
                <div class="">
                    <a href="{{ route('planes.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Planes</a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            {!! Form::open([
                'method' => 'POST',
                'route' => ['planes.store'],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formCrearPlan' ]) !!}
                @csrf

                @include('planes.fields_planes')

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorStore" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <div class="mt-4 mb-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success rounded-2 me-3">
                        <i class="fa fa-floppy-o"></i>
                        Crear
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            // ===================================================================================
            
            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formCrearPlan"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // ===================================================================================

            // formCrearUsuario para cargar gif en el submit
            $("form").on("submit", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                // const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                // cancelButton.prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop
