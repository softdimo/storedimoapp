@extends('layouts.app')
@section('title', 'Editar Plan')

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

                <div class="">
                    <a href="{{ route('planes.create') }}" class="btn text-white"
                        style="background-color:#337AB7">Crear Plan</a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Editar Plan (Obligatorios * )
                </h5>

                {!! Form::open([
                    'method' => 'PUT',
                    'route' => ['planes.update', $planEdit->id_plan],
                    'class' => 'mt-2',
                    'autocomplete' => 'off',
                    'id' => 'formEditarPlan_' . $planEdit->id_plan ]) !!}
                    @csrf
    
                    @include('planes.fields_planes')
    
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
    
                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorEditarPlan_{{ $planEdit->id_plan }}" class="loadingIndicator">
                        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                    </div>
    
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
    
                    <div class="mt-4 mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2 me-3" id="btn_editar_plan_{{ $planEdit->id_plan }}">
                            <i class="fa fa-floppy-o"> Editar</i>
                        </button>
                    </div>
                {!! Form::close() !!}
            </div> {{-- FIN div_editar_plan --}}
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
                allowClear: false,
                width: '100%'
            });

            // ===================================================================================
            
            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formEditarPlan_"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // ===================================================================================

            // formEditarPlan para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditarPlan_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const submitButton = $(`#btn_editar_plan_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditarPlan_${id}`);

                // Lógica del botón
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop
