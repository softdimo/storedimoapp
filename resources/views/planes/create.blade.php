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
            <div class="d-flex justify-content-between pe-3 mt-3 mb-3">
                <div class="">
                    <a href="{{ route('planes.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Planes</a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Crear Plan (Obligatorios * )
                </h5>

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

                    <div class="mt-4 mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2 me-3">
                            <i class="fa fa-floppy-o"></i>
                            Crear
                        </button>
                    </div>
                {!! Form::close() !!}
            </div> {{-- FIN div_crear_plan --}}
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

            $('.select2').on('select2:open', function (e) {
                // Buscamos el input de búsqueda dentro del contenedor de Select2 y le damos foco
                document.querySelector('.select2-search__field').focus();
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
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop
