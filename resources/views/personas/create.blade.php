@extends('layouts.app')
@section('title', 'Crear Personas')

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
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}

        {{-- ======================================================================= --}}

        <div class="p-3 content-container">
            <div class="d-flex justify-content-between pe-3 mt-3">


                <div class="">
                    <a href="{{ route('listar_clientes') }}" class="btn text-white"
                        style="background-color:#337AB7">Clientes</a>
                </div>

                <div class="{{-- text-end --}}">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaCrearPersonas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="modal fade" id="modalAyudaCrearPersonas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 75%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-5"><strong>Ayuda Registrar Clientes</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario a la hora de realizar un registro tener en
                                            cuenta las siguientes recomendaciones:</p>

                                        <ol>
                                            <li class="text-justify">Todos los campos que poseen el asterisco (*) son
                                                obligatorios, por lo tanto sino se diligencian, el sistema no le dejará
                                                seguir.</li>
                                            <li class="text-justify">El campo número de documento, su logitud debe ser mayor
                                                a los 7 caracteres.</li>
                                            <li class="text-justify">En el momento del registro no se debe ingresar un
                                                número de documento ya existente en la base de datos.</li>
                                        </ol>
                                    </div> {{-- FINpanel-body --}}
                                </div> {{-- FIN col-12 --}}
                            </div> {{-- FIN modal-body .row --}}
                        </div> {{-- FIN modal-body --}}
                        {{-- =========================== --}}
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md active pull-right"
                                    data-bs-dismiss="modal" style="background-color: #337AB7;">
                                    <i class="fa fa-check-circle" aria-hidden="true">&nbsp;Aceptar</i>
                                </button>
                            </div>
                        </div>
                    </div> {{-- FIN modal-content --}}
                </div> {{-- FIN modal-dialog --}}
            </div> {{-- FIN modalAyudaModificacionProductos --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            {!! Form::open([
                'method' => 'POST',
                'route' => ['personas.store'],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formCrearPersonas',
            ]) !!}
            @csrf

            @include('personas.fields_crear_personas')
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
                placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            // Inicializar intlTelInput para el campo celular en el modal
            initIntlPhone("#celular");

            // Inicializar función de validación de número de teléfono
            initPhoneValidation("#numero_telefono", "#telefono-error");

            $('#div_proveedor_juridico').hide();

            $('#id_tipo_persona').change(function() {
                let idTipoPersona = $('#id_tipo_persona').val();

                if (idTipoPersona == 4) { // Proveedor-juridico
                    $('#div_identificacion').hide('slow');
                    $('#identificacion').removeAttr('required');

                    $('#div_nombres_persona').hide('slow');
                    $('#nombres_persona').removeAttr('required');

                    $('#div_apellidos_persona').hide('slow');
                    $('#apellidos_persona').removeAttr('required');

                    $('#div_numero_telefono').hide('slow');
                    $('#numero_telefono').removeAttr('required');

                    $('#div_celular').show('slow');
                    $('#div_celular').removeClass('mt-3');
                    $('#celular').attr('required');

                    $('#div_email').show('slow');
                    $('#div_email').removeClass('mt-3');
                    $('#email').attr('required');

                    $('#div_direccion').show('slow');
                    $('#direccion').attr('required');

                    $('#div_id_genero').hide('slow');
                    $('#id_genero').removeAttr('required');

                    $('#div_proveedor_juridico').show();
                    $('#nit_empresa').attr('required');
                    $('#nombre_empresa').attr('required');
                    $('#telefono_empresa').attr('required');
                } else {
                    $('#div_identificacion').show('slow');
                    $('#identificacion').attr('required');

                    $('#div_nombres_persona').show('slow');
                    $('#nombres_persona').attr('required');

                    $('#div_apellidos_persona').show('slow');
                    $('#apellidos_persona').attr('required');

                    $('#div_numero_telefono').show('slow');
                    $('#numero_telefono').attr('required');

                    $('#div_celular').show('slow');
                    $('#div_celular').addClass('mt-3');
                    $('#celular').attr('required');

                    $('#div_email').show('slow');
                    $('#div_email').addClass('mt-3');
                    $('#email').attr('required');

                    $('#div_direccion').show('slow');
                    $('#direccion').attr('required');

                    $('#div_id_genero').show('slow');
                    $('#id_genero').attr('required');

                    $('#div_proveedor_juridico').hide();
                    $('#nit_empresa').removeAttr('required');
                    $('#nombre_empresa').removeAttr('required');
                    $('#telefono_empresa').removeAttr('required');
                }
            }); // FIN Tipo Persona Jurídica

            // ===================================================================================
            // ===================================================================================

            // formCrearPersonas para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearPersonas']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find(
                "div[id^='loadingIndicatorPersonaStore']"); // Busca el GIF del form actual

                // Dessactivar Botones
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop
