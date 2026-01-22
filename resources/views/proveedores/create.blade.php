@extends('layouts.app')
@section('title', 'Crear Proveedores')

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
                    <a href="{{ route('proveedores.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Proveedores</a>
                </div>

                <div class="">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaCrearProveedor">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="modal fade" id="modalAyudaCrearProveedor" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 55%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-5"><strong>Ayuda Registrar Proveedores</strong></span>
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
                'route' => ['proveedores.store'],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formCrearProveedores' ]) !!}
                @csrf

                @include('proveedores.fields_crear_proveedores')

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

            // Inicializar intlTelInput para el campo celular en el modal
            initIntlPhone("#celular_proveedor");

            // Inicializar función de validación de número de teléfono fijo natural
            initPhoneValidation("#numero_telefono", "#telefono-error");

            // Inicializar función de validación de número de teléfono fijo jurídico
            initPhoneValidation("#telefono_empresa", "#telefono-error");

            // Inicializar función de validación de NIT (Solo validación local de 10 dígitos por ahora sin validar el nit en la api)
            initNitValidation("#nit_proveedor", "#nit-error");

            /* // DESCOMENTAR ESTO CUANDO SE NECESITE VALIDAR EL NIT CONTRA EL SERVIDOR
            initNitValidation("#nit_proveedor", "#nit-error", async function(nit, $input, $errorMsg) {
                try {
                    const response = await fetch("{{ route('nit_validator_proveedor') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({ nit_proveedor: nit })
                    });

                    const data = await response.json();

                    if (!response.ok || data.valido === false) {
                        $errorMsg.text(data.error || "Este NIT ya está registrado.").removeClass("d-none");
                        $input.addClass("is-invalid").val("");
                    } else {
                        $input.addClass("is-valid");
                    }
                } catch (error) {
                    $errorMsg.text("Error al validar el NIT en el servidor.").removeClass("d-none");
                }
            });
            */

            // ======================================================

            $('#div_nit_proveedor').hide();
            $('#div_proveedor_juridico').hide();
            $('#div_telefono_empresa').hide();

            // 3. Lógica de visibilidad por Tipo de Persona
            $('#id_tipo_persona').change(function() {
                let idTipoPersona = $(this).val();

                // Limpiar errores visuales previos
                $('.text-danger').addClass('d-none');
                $('.is-invalid').removeClass('is-invalid');

                if (idTipoPersona == 4) { // Proveedor-jurídico
                    // OCULTAR campos de persona natural
                    $('#div_identificacion, #div_nombres_persona, #div_apellidos_persona, #div_numero_telefono, #div_id_genero').hide('slow');
                    $('#identificacion, #nombres_persona, #apellidos_persona, #numero_telefono').removeAttr('required').val('');
                    $('#id_genero').removeAttr('required').val('').trigger('change'); // Limpia select2

                    // MOSTRAR campos de empresa
                    $('#div_nit_proveedor, #div_proveedor_juridico, #div_telefono_empresa').show('slow');
                    $('#nit_proveedor, #nombre_empresa').attr('required', 'required');
                    
                    // REPLICAR TUS ESTILOS mt-3
                    $('#div_celular, #div_email, #div_telefono_empresa').addClass('mt-3');
                    $('#celular, #email_proveedor').attr('required', 'required');

                } else { // Natural u otros
                    // MOSTRAR campos de persona natural
                    $('#div_identificacion, #div_nombres_persona, #div_apellidos_persona, #div_numero_telefono, #div_id_genero').show('slow');
                    $('#identificacion, #nombres_persona, #apellidos_persona, #id_genero').attr('required', 'required');
                    $('#numero_telefono').removeAttr('required');

                    // OCULTAR campos de empresa
                    $('#div_nit_proveedor, #div_proveedor_juridico, #div_telefono_empresa').hide('slow');
                    $('#nit_proveedor, #nombre_empresa, #telefono_empresa').removeAttr('required').val('');

                    // REPLICAR TUS ESTILOS mt-3
                    $('#div_celular, #div_email').addClass('mt-3');
                    $('#celular, #email_proveedor').attr('required', 'required');
                }
            }).trigger('change');

            // $('#id_tipo_persona').change(function() {
            //     let idTipoPersona = $('#id_tipo_persona').val();

            //     if (idTipoPersona == 4) { // Proveedor-juridico
            //         $('#div_identificacion').hide('slow');
            //         $('#identificacion').removeAttr('required');
            //         $('#identificacion').val('');

            //         $('#div_nombres_persona').hide('slow');
            //         $('#nombres_persona').removeAttr('required');
            //         $('#nombres_persona').val('');

            //         $('#div_apellidos_persona').hide('slow');
            //         $('#apellidos_persona').removeAttr('required');
            //         $('#apellidos_persona').val('');

            //         $('#div_numero_telefono').hide('slow');
            //         $('#numero_telefono').removeAttr('required');
            //         $('#numero_telefono').val('');

            //         $('#div_celular').show('slow');
            //         $('#div_celular').addClass('mt-3');
            //         $('#celular').attr('required');

            //         $('#div_email').show('slow');
            //         $('#div_email').addClass('mt-3');
            //         $('#email_proveedor').attr('required');

            //         $('#div_direccion').show('slow');
            //         $('#direccion_proveedor').attr('required');

            //         $('#div_id_genero').hide('slow');
            //         $('#id_genero').removeAttr('required');
            //         $('#id_genero').val('').trigger('change');

            //         $('#div_nit_proveedor').show();
            //         $('#nit_proveedor').attr('required');

            //         $('#div_proveedor_juridico').show();
            //         $('#nombre_empresa').attr('required');

            //         $('#div_telefono_empresa').show();
            //         $('#div_telefono_empresa').addClass('mt-3');
            //         $('#telefono_empresa').removeAttr('required');
            //     } else {
            //         $('#div_identificacion').show('slow');
            //         $('#identificacion').attr('required');

            //         $('#div_nombres_persona').show('slow');
            //         $('#nombres_persona').attr('required');

            //         $('#div_apellidos_persona').show('slow');
            //         $('#apellidos_persona').attr('required');

            //         $('#div_numero_telefono').show('slow');
            //         $('#numero_telefono').removeAttr('required');

            //         $('#div_celular').show('slow');
            //         $('#div_celular').addClass('mt-3');
            //         $('#celular').attr('required');

            //         $('#div_email').show('slow');
            //         $('#div_email').addClass('mt-3');
            //         $('#email_proveedor').attr('required');

            //         $('#div_direccion').show('slow');
            //         $('#direccion_proveedor').attr('required');

            //         $('#div_id_genero').show('slow');
            //         $('#id_genero').attr('required');

            //         $('#div_nit_proveedor').hide();
            //         $('#nit_proveedor').removeAttr('required');
            //         $('#nit_proveedor').val('');

            //         $('#div_proveedor_juridico').hide();
            //         $('#nombre_empresa').removeAttr('required');
            //         $('#nombre_empresa').val('');

            //         $('#div_telefono_empresa').hide();
            //         $('#telefono_empresa').removeAttr('required');
            //         $('#telefono_empresa').val('');
            //     }
            // }); // FIN Tipo Persona Jurídica

            

            // ===================================================================================
            // ===================================================================================

            $(document).on("submit", "form[id^='formCrearProveedores']", function(e) {
                e.preventDefault();
                
                const form = $(this);
                const emailInput = $('#email_proveedor');
                const emailValue = emailInput.val();
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorPersonaStore']");

                if (!emailValue) return;

                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Validando... <i class='fa fa-spinner fa-spin'></i>");
                loadingIndicator.show();

                $.ajax({
                    url: "{{ route('validar_correo_proveedor') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'email_proveedor': emailValue
                    },
                    success: function(respuesta) {
                        // Si el objeto respuesta existe y trae el email, está duplicado
                        if (respuesta && respuesta.email_proveedor == emailValue) {
                            Swal.fire('Cuidado!', 'Este correo ya está registrado', 'warning');
                            
                            emailInput.val('').addClass('is-invalid');
                            cancelButton.prop("disabled", false);
                            submitButton.prop("disabled", false).html("Guardar");
                            loadingIndicator.hide();
                        } else {
                            // EL CORREO ES VÁLIDO
                            submitButton.html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                            
                            // --- CAMBIO CLAVE AQUÍ ---
                            // form[0] accede al elemento DOM puro.
                            // El método .submit() nativo NO dispara los eventos de jQuery, evitando el bucle.
                            form[0].submit(); 
                        }
                    },
                    error: function() {
                        // En caso de error de servidor, rehabilitamos para intentar de nuevo
                        cancelButton.prop("disabled", false);
                        submitButton.prop("disabled", false).html("Guardar");
                        loadingIndicator.hide();
                    }
                });
            });
        }); // FIN document.ready
    </script>
@stop
