@extends('layouts.app')
@section('title', 'Crear Empresas')

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
        <div class="p-0 ">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 content-container">
            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('empresas.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Empresas</a>
                </div>

                <div class="">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaCrearEmpresas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="modal fade" id="modalAyudaCrearEmpresas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-5"><strong>Ayuda Registrar Empresas</strong></span>
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

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Crear Empresa (Obligatorios * )
                </h5>

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['empresas.store'],
                    'class' => 'mt-2',
                    'autocomplete' => 'off',
                    'id' => 'formCrearEmpresas',
                    'enctype' => 'multipart/form-data',
                    'file' => true,
                ]) !!}
                @csrf

                @include('empresas.fields_empresas')

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorEmpresaStore" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <div class="mt-5 mb-2 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success rounded-2 me-3">
                        <i class="fa fa-floppy-o"></i>
                        Guardar
                    </button>
                </div>
                {!! Form::close() !!}
            </div> {{-- FIN div_crear_empresa --}}
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
            initIntlPhone("#celular_empresa");

            // Inicializar función de validación de número de teléfono
            initPhoneValidation("#telefono_empresa", "#telefono-error");

            // Inicializar función de validación de NIT
            initNitValidation("#nit_empresa", "#nit-error");


            // formCrearEmpresas para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearEmpresas']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find(
                    "div[id^='loadingIndicatorEmpresaStore']"); // Busca el GIF del form actual

                // Dessactivar Botones
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });

            //================================
            // Validación de nit de empresa al salir del campo
            //================================
            const nitInput = document.getElementById('nit_empresa');
            const errorNitMsg = document.getElementById('nit-error');
            let errorTimeout;

            const mostrarErrorNit = (mensaje) => {
                errorNitMsg.textContent = mensaje;
                errorNitMsg.classList.remove('d-none');
                nitInput.classList.add('is-invalid');

                clearTimeout(errorTimeout);

                errorTimeout = setTimeout(() => {
                    limpiarErrorNit();
                }, 4000);

            };

            const limpiarErrorNit = () => {
                errorNitMsg.classList.add('d-none');
                nitInput.classList.remove('is-invalid');
            };

            nitInput.addEventListener('blur', async () => {
                const nit = nitInput.value.trim();
                limpiarErrorNit();

                if (nit === '') {
                    mostrarErrorNit('El NIT es obligatorio.');
                    return;
                }

                try {
                    const response = await fetch("{{ route('nit_validator') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            nit_empresa: nit
                        })
                    });

                    if (!response.ok) throw new Error('Error en la petición');

                    const data = await response.json();

                    if (!data.valido) {
                        mostrarErrorNit('Este NIT ya está registrado.');
                        nitInput.value = '';
                    }

                } catch (error) {
                    console.error('Error al validar el NIT:', error);
                    mostrarErrorNit('Ocurrió un error. Intente más tarde.');
                }
            });
            //================================
            // Fin de validación de nit de empresa
            //================================
        }); // FIN document.ready



        // =============================================

        // Funcionalidad input tipo file para imagen producto
        function displaySelectedFile(inputId, displayElementId) {
            const input = document.getElementById(inputId);
            const displayElement = document.getElementById(displayElementId);
            const file = input.files[0];

            // Reset
            displayElement.textContent = '';
            displayElement.classList.add('hidden');

            if (file) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                const maxSizeMB = 2;
                const fileSizeMB = file.size / (1024 * 1024);

                if (!allowedTypes.includes(file.type)) {
                    displayElement.textContent = 'Formato no permitido. Solo JPG, JPEG, PNG o WEBP.';
                    displayElement.classList.remove('hidden');
                    input.value = ''; // limpia el input
                    return;
                }

                if (fileSizeMB > maxSizeMB) {
                    displayElement.textContent = 'El archivo excede los 2MB permitidos.';
                    displayElement.classList.remove('hidden');
                    input.value = ''; // limpia el input
                    return;
                }

                // Todo bien
                displayElement.textContent = file.name;
                displayElement.classList.remove('hidden');
            }
        }
    </script>
@stop
