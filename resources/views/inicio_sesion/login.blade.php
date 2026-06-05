@extends('layouts.app')
@section('title', 'Login')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="bg-light p-4">
        <div class="d-flex flex-row justify-content-between">
            <div class="col-12 col-md-8 pe-4" id="descripcion_landing">
                <h1 class="mb-4 fw-bold text-primary text-center">Que es Storedimo</h1>
                @include('layouts.descripcionLanding')
            </div>

            <div class="col-12 col-md-4 border border-dark-subtle p-4 shadow-lg rounded-4 bg-white text-center" style="overflow-y: auto;">
                <div class="d-flex justify-content-center p-3">
                    <img src="{{asset('imagenes/logo_storedimo_fondo.png')}}" alt="logo" class="text-center" width="200" height="100">
                </div>
                
                <form class="p-3" method="post" action="{{route('login.store')}}" autocomplete="off">
                    @csrf
                    
                    <h3 class="mb-4 fw-bold text-primary">Iniciar Sesión</h3>

                    <div class="mb-4">
                        <input type="email" name="email" id="email" class="w-100 form-control p-3" placeholder="Correo *" required>
                    </div>
                    
                    <div class="mb-4 position-relative">
                        <input type="password" name="clave" id="clave" class="w-100 form-control p-3" placeholder="Contraseña *" required>
                        <span class="btn-show-pass position-absolute top-50 end-0 translate-middle-y me-3">
                            <i class="zmdi zmdi-eye fs-5"></i>
                        </span>
                    </div>
                    
                    <button class="btn btn-primary btn-lg w-100" type="submit">Iniciar Sesión</button>
                    
                    <div class="mt-3">
                        <a href="{{route('recuperar_clave')}}" class="text-primary">¿Olvidó la Contraseña?</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-5" id="planes_landing">
            <h1 class="mb-4 fw-bold text-primary text-center">Planes</h1>
            @include('layouts.planesLanding')
        </div>

        <div class="mt-5" id="registro_landing">
            <h1 class="mb-4 fw-bold text-primary text-center">Registro</h1>
            @include('layouts.formCrearEmpresaSuscripcionLanding')
        </div>

    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {

            $("#email").focus();

            //================================

            // Empresa
            $('#div_nit_empresa').hide();
            $('#nit_empresa').removeAttr('required');

            $('#div_ident_empresa_natural').hide();
            $('#ident_empresa_natural').removeAttr('required');

            //================================

            $('#id_tipo_documento').change(function() {
                let idTipoDocumento = $('#id_tipo_documento').val();

                console.log(idTipoDocumento);

                if (idTipoDocumento == 3) { // Nit
                    $('#div_nit_empresa').show();
                    $('#nit_empresa').attr('required');

                    $('#div_ident_empresa_natural').hide();
                    $('#ident_empresa_natural').removeAttr('required');

                    $('#div_celular').addClass('mt-3');
                    
                } else if (idTipoDocumento != 3 && idTipoDocumento != '') {
                    $('#div_nit_empresa').hide();
                    $('#nit_empresa').removeAttr('required');

                    $('#div_ident_empresa_natural').show();
                    $('#ident_empresa_natural').attr('required');

                    $('#div_celular').addClass('mt-3');

                } else {
                    $('#div_nit_empresa').hide();
                    $('#nit_empresa').removeAttr('required');

                    $('#div_ident_empresa_natural').hide();
                    $('#ident_empresa_natural').removeAttr('required');

                    $('#div_celular').removeClass('mt-3');
                }
            });

            // Inicializamos el NIT pasando la lógica del servidor como tercer parámetro
            initNitValidation("#nit_empresa", "#nit-error", async function(nit, $input, $errorMsg) {
                try {
                    const response = await fetch("{{ route('nit_validator_landing') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({ nit_empresa: nit })
                    });

                    const data = await response.json();

                    if (!response.ok) { // Si el controlador devuelve 422 o 500
                        $errorMsg.text(data.error || "Error de validación").removeClass("d-none");
                        $input.addClass("is-invalid").val("");
                    } else if (data.valido === false) { // Si el NIT ya existe
                        console.log(data);
                        console.log(data.empresa);
                        console.log(data.empresa.id_estado);

                        if (data.empresa.id_estado == 13) {
                            Swal.fire('Atención!',
                                'Este NIT ya está registrado y tiene un proceso de suscripción en activación',
                                'info'
                            )
                        } else if (data.empresa.id_estado == 14) {
                            Swal.fire({
                                title: '¡Pago pendiente!',
                                text: 'Este NIT ya está registrado pero el pago no fue completado. ¿Deseas intentar el pago nuevamente?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, pagar ahora',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                console.log(result.value);
                                if (result.value == true) {
                                    window.location.href = "{{ url('/empresa_pago_fallido') }}/" + data.empresa.id_empresa + "/reintentar_pago";
                                }
                            });
                        } else {
                            $errorMsg.text("Este NIT ya está registrado.").removeClass("d-none");
                            $input.addClass("is-invalid").val("");
                        }

                    } else {
                        // Todo perfecto
                        $input.addClass("is-valid");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    $errorMsg.text("Error al conectar con el servidor.").removeClass("d-none");
                }
            });
            // FIN initNitValidation

            //================================
            // Validación de nit de empresa al salir del campo
            //================================
            const nitInput = document.getElementById('nit_empresa');
            const errorNitMsg = document.getElementById('nit-error');
            let errorTimeout;

            //================================

            const limpiarErrorNit = () => {
                errorNitMsg.classList.add('d-none');
                nitInput.classList.remove('is-invalid');
            };

            //================================

            initDynamicIdValidationLanding({
                selectSelector: "#id_tipo_documento",
                inputSelector: "#ident_empresa_natural",
                errorSelector: "#ident-natural-error",
                map: {
                    "1": { onlyNumbers: true,  min: 7, max: 10, label: "número de cédula" },
                    "2": { onlyNumbers: false, min: 6, max: 15, label: "pasaporte" },
                    "4": { onlyNumbers: false, min: 10, max: 15, label: "permiso especial" },
                    "5": { onlyNumbers: false, min: 6, max: 12, label: "cédula de extranjería" }
                },
                // <-- AGREGADO: Aquí procesamos los datos exactos del cliente/empresa natural
                serverValidationCallback: async function(documento, $input, $errorMsg) {
                    try {
                        const response = await fetch("{{ route('documento_validator_landing') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ident_empresa_natural: documento
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            $errorMsg.text(data.error || "Error de validación").removeClass("d-none");
                            $input.addClass("is-invalid").val("");
                        } else if (data.valido === false) {
                            
                            if (data.empresa.id_estado == 13) {
                                Swal.fire('Atención!',
                                    'Este documento ya está registrado y tiene un proceso de suscripción en activación',
                                    'info'
                                );
                                $input.addClass("is-invalid").val("");
                            } else if (data.empresa.id_estado == 14) {
                                Swal.fire({
                                    title: '¡Pago pendiente!',
                                    text: 'Este documento ya está registrado pero el pago no fue completado. ¿Deseas intentar el pago nuevamente?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sí, pagar ahora',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed || result.value == true) {
                                        window.location.href = "{{ url('/empresa_pago_fallido') }}/" + data.empresa.id_empresa + "/reintentar_pago";
                                    } else {
                                        $input.addClass("is-invalid").val("");
                                    }
                                });
                            } else {
                                $errorMsg.text("Este documento ya está registrado.").removeClass("d-none");
                                $input.addClass("is-invalid").val("");
                            }

                        } else {
                            // Todo perfecto
                            $input.addClass("is-valid");
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        $errorMsg.text("Error al conectar con el servidor.").removeClass("d-none");
                    }
                }
            });

            //================================

            // Inicializar intlTelInput para el campo celular en el modal
            // initIntlPhone("#celular_empresa");

            //================================

            // Inicializar función de validación de número de teléfono
            // initPhoneValidation("#telefono_empresa", "#telefono-error");

            //================================
            // Inicio validación correo
            //================================
            $('#email_empresa').blur(function() {
                let emailEmpresa = $('#email_empresa').val();

                $.ajax({
                    url: "{{ route('validar_correo_empresa_landing') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'email_empresa': emailEmpresa
                    },
                    success: function(respuesta) {
                        console.log(respuesta);

                        // Validamos si el objeto respuesta tiene datos (no está vacío)
                        // y si el email coincide con el que escribió el usuario
                        if (respuesta && respuesta.email_empresa == emailEmpresa) {
                            Swal.fire('Cuidado!',
                                'Este correo ya está registrado',
                                'warning'
                            )
                            $('#email_empresa').val('');
                        }
                    },
                    error: function(error) {
                        console.error("Error en la validación:", error);
                    }
                });
            });

            // ==============================================================
            // ==============================================================
            // ==============================================================

            // Suscripción
            $('#div_dias_trial').hide();
            $('#div_valor_mensual').hide();
            $('#div_valor_trimestral').hide();
            $('#div_valor_semestral').hide();
            $('#div_valor_anual').hide();
            $('#div_descripcion_plan').hide();
            $('#div_id_tipo_pago').hide();

            // ==============================================================
            // ==============================================================

            const planesData = @json($planesData);
            console.log('planesData cargados:', planesData);

            // ==============================================================
            // ==============================================================

            // Función para obtener fecha LOCAL en formato YYYY-MM-DD
            function obtenerHoy() {
                const fecha = new Date();
                const year = fecha.getFullYear();
                const month = String(fecha.getMonth() + 1).padStart(2, '0'); // Meses van de 0-11
                const day = String(fecha.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Función para sumar días respetando la zona horaria local
            function sumarDias(fechaString, dias) {
                // Truco: Al crear date con string "YYYY-MM-DD" javascript lo asume UTC a veces.
                // Mejor crearlo y ajustar componentes.
                const fecha = new Date(fechaString + 'T00:00:00'); // Forzamos hora local inicio día
                fecha.setDate(fecha.getDate() + parseInt(dias));
                
                const year = fecha.getFullYear();
                const month = String(fecha.getMonth() + 1).padStart(2, '0');
                const day = String(fecha.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // ==============================================================
            // ==============================================================

            // Usar jQuery + eventos de Select2 para máxima compatibilidad
            $('#id_plan_suscrito').on('change', function (e) {
                // obtener valor (siempre string)
                const idPlan = $(this).val();

                // obtener objeto del plan (las claves en planesData son strings; si no, convertimos)
                const plan = planesData[idPlan] ?? planesData[String(idPlan)] ?? null;

                // asignar valores a los inputs (si plan es null, dejar vacío)
                if (idPlan == 1) { // Trial

                    $('#div_dias_trial').show();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    $('#id_tipo_pago').val('').trigger('change'); // Reiniciar selección

                    $('#valor_suscripcion').val(0);

                    // 1. Obtener fecha de hoy
                    const hoy = obtenerHoy();
                    
                    // 2. Asignar a fecha inicial
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').val(hoy).trigger('change');

                    // 3. Calcular días (asegurate que plan.dias_trial sea un número)
                    let diasTrial = $('#dias_trial').val();
                    const dias = (plan && plan.dias_trial) ? parseInt(plan.dias_trial) : diasTrial;

                    // 4. Calcular fecha final
                    const fechaFin = sumarDias(hoy, dias);
                    console.log('fechaInicial:', hoy);
                    console.log('fechaFin:', fechaFin);
                    
                    // 5. Asignar fecha final
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').val(fechaFin).trigger('change');
                    
                    // AGREGAR: Bloquear escritura para que no modifiquen los 15 días
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');

                    // Asignar 10 a estado Trial
                    // $('#formCrearSuscripcionEmpresaLanding').find('#id_estado_suscripcion').val(1).trigger('change');
                    
                } else if (idPlan != 1 && idPlan != '') {

                    $('#div_dias_trial').hide();

                    $('#div_valor_mensual').show();
                    $('#valor_mensual').val(plan.valor_mensual ?? '');

                    $('#div_valor_trimestral').show();
                    $('#valor_trimestral').val(plan.valor_trimestral ?? '');

                    $('#div_valor_semestral').show();
                    $('#valor_semestral').val(plan.valor_semestral ?? '');

                    $('#div_valor_anual').show();
                    $('#valor_anual').val(plan.valor_anual ?? '');

                    $('#div_descripcion_plan').show();
                    $('#descripcion_plan').val(plan.descripcion_plan ?? '');

                    $('#div_id_tipo_pago').show();
                    $('#id_tipo_pago').attr('required');
                    $('#valor_suscripcion').val('');

                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').val('').trigger('change');
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').val('').trigger('change');

                    // AGREGAR: Permitir escritura nuevamente
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    $('#formCrearSuscripcionEmpresaLanding').find('#id_estado_suscripcion').val('').trigger('change');

                } else {

                    $('#div_dias_trial').hide();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    $('#id_tipo_pago').val('').trigger('change'); // Reiniciar selección

                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').val('').trigger('change');
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').val('').trigger('change');

                    $('#valor_suscripcion').val('');

                    // AGREGAR: Limpiar atributos por si acaso
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    $('#formCrearSuscripcionEmpresaLanding').find('#id_estado_suscripcion').val('').trigger('change');
                }
            });

            // ==============================================================
            // ==============================================================

            $('#id_tipo_pago').on('change', function (e) {

                const idTipoPago = $(this).val();
                console.log(idTipoPago);
                
                let valorMensual = $('#valor_mensual').val();
                let valorTrimestral = $('#valor_trimestral').val();
                let valorSemestral = $('#valor_semestral').val();
                let valorAnual = $('#valor_anual').val();

                let valorSuscripcion = $('#valor_suscripcion');

                // Calcular días (asegurate que plan.dias_trial sea un número)
                let diasMensual = 30;
                let diasTrimestral = 90;
                let diasSemestral = 180;
                let diasAnual = 365;

                // Obtener fecha de hoy
                const hoy = obtenerHoy();

                let fechaFin = '';

                if (idTipoPago == 7) { // Mensual
                    valorSuscripcion.val(valorMensual);
                    fechaFin = sumarDias(hoy, diasMensual);

                } else if (idTipoPago == 8) { // Trimestral
                    valorSuscripcion.val(valorTrimestral);
                    fechaFin = sumarDias(hoy, diasTrimestral);

                } else if (idTipoPago == 9) { // Semestral
                    valorSuscripcion.val(valorSemestral);
                    fechaFin = sumarDias(hoy, diasSemestral);

                } else if (idTipoPago == 6) { // Anual
                    valorSuscripcion.val(valorAnual);
                    fechaFin = sumarDias(hoy, diasAnual);
                    
                } else {
                    valorSuscripcion.val('');
                }

                // Asignar a fecha inicial y fechfinal
                $('#formCrearSuscripcionEmpresaLanding').find('#fecha_inicial').val(hoy).trigger('change');
                $('#formCrearSuscripcionEmpresaLanding').find('#fecha_final').val(fechaFin).trigger('change');

                $('#formCrearSuscripcionEmpresaLanding').find('#id_estado_suscripcion').val(1).trigger('change');
            });

            // ==============================================================
            // ==============================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formCrearSuscripcionEmpresaLanding"]', function (e) {
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
                const loadingIndicator = form.find("div[id^='loadingIndicatorEmpresaSuscripcionStore']");

                // Dessactivar Botones
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });
        });
    </script>
@stop


