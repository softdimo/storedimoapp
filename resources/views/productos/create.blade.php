@extends('layouts.app')
@section('title', 'Registrar Productos')

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
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <a href="{{ route('productos.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Productos</a>
                </div>

                <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                    data-bs-target="#modalAyudaRegistrarProductos">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div>

            <div class="modal fade" id="modalAyudaRegistrarProductos" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Registrar Productos</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario a la hora de realizar un registro tener en
                                            cuenta las siguientes recomendaciones:</p>

                                        <ol>
                                            <li class="text-justify">Los campos marcados con asterisco (*) son obligatorios,
                                                por lo tanto sino se llenan el sistema no le dejará seguir.</li>
                                            <li class="text-justify">Evitar ingresar nombres de productos ya existentes.
                                            </li>
                                            <li class="text-justify">El precio unitario no puede ser mayor al precio al
                                                detal y precio al por mayor.</li>
                                            <li class="text-justify">El precio al detal no puede ser menor al precio al por
                                                mayor.</li>
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
                'route' => ['productos.store'],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formCrearProducto',
                'enctype' => 'multipart/form-data',
                'file' => true,
            ]) !!}
            @csrf

            @include('productos.fields_crear_productos')
            {!! Form::close() !!}
        </div>
    </div>

    @include('productos.modal_crear_umd')

    <!-- Modal Crear Categoría -->
    <div class="modal fade" id="modal_crear_categoria" tabindex="-1" aria-labelledby="modalCrearCategoriaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #337AB7">
                    <h5 class="modal-title" id="modalCrearCategoriaLabel">Crear Nueva Categoría</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearCategoria" method="POST" action="{{ route('categorias.store') }}">
                        @csrf
                        <div class="p-3 d-flex flex-column">
                            <div>
                                <label for="categoria">Nombre Categoría<span class="text-danger"> *</span></label>
                                <input type="text" name="categoria" id="categoria" class="form-control" required
                                    minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'\-]{3,100}$"
                                    title="Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 3 caracteres)"
                                    placeholder="Ingrese nombre de categoría">
                            </div>

                            <!-- Contenedor para el GIF -->
                            <div id="loadingIndicatorCrearCategoria" class="loadingIndicator" style="display: none;">
                                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-success rounded-2 me-3">
                                    <i class="fa fa-floppy-o"></i>
                                    Guardar
                                </button>
                                {{-- <button type="button" class="btn btn-danger rounded-2" data-bs-dismiss="modal">
                                    <i class="fa fa-remove"></i>
                                    Cancelar
                                </button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal Crear Categoría -->
@stop

@section('scripts')
    <script>
        $(document).ready(function()
        {

            $('.select2').select2({
                // placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            $('.select2').on('select2:open', function (e) {
                // Buscamos el input de búsqueda dentro del contenedor de Select2 y le damos foco
                document.querySelector('.select2-search__field').focus();
            });

            // Valido si el nombre del producto existe
            $('#id_categoria').blur(function()
            {
                let nombreProducto = $('#nombre_producto').val();
                let idCategoria = $('#id_categoria').val();

                $.ajax({
                    url: "{{ route('verificar_producto') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'nombre_producto': nombreProducto,
                        'id_categoria': idCategoria,
                    },
                    success: function(respuesta) {
                        if (respuesta == "existe_producto") {
                            Swal.fire(
                                'Cuidado!',
                                'Este producto ya existe!',
                                'warning'
                            )
                            $('#nombre_producto').val('');
                        }

                        if (respuesta == "error_exception") {
                            Swal.fire(
                                'Error!',
                                'No fue posible consultar el producto, intente nuevamente!',
                                'error'
                            )
                        }
                    }
                });
            });

            // =============================================
            // Función para abrir el modal de crear categoría
            $('#formCrearCategoria').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = $('#loadingIndicatorCrearCategoria');

                // Deshabilitar botón y mostrar loading
                submitButton.prop('disabled', true);
                loadingIndicator.show();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Cerrar modal y resetear formulario
                            $('#modal_crear_categoria').modal('hide');
                            form[0].reset();

                            // Mostrar mensaje de éxito
                            Swal.fire({
                                type: 'success',
                                title: '¡Éxito!',
                                text: response.message ||
                                    'Categoría creada correctamente',
                                showConfirmButton: false,
                                timer: 1500,
                                // timerProgressBar: true,
                            });
                            // Recargar la vista después de cerrar el mensaje
                            location.reload();
                        } else {
                            // throw new Error(response.message || 'Error al crear la categoría');

                            Swal.fire({
                                type: 'warning',
                                title: '¡Precaución!',
                                text: response.message || 'Existe',
                                showConfirmButton: false,
                                timer: 1500,
                                // timerProgressBar: true,
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error al crear la categoría';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    },
                    complete: function() {
                        // Rehabilitar botón y ocultar loading
                        submitButton.prop('disabled', false);
                        loadingIndicator.hide();
                    }
                });
            });
            // Fin de función para abrir el modal de crear categoría

            // Valido que el precio unitario sea menor que el precio al detal
            $('#precio_detal').blur(function() {
                let precioUnitario = parseFloat($('#precio_unitario').val()) || 0;
                let precioDetal = parseFloat($('#precio_detal').val()) || 0;

                if (precioUnitario >= precioDetal) {
                    Swal.fire(
                        'Cuidado!',
                        'El precio unitario debe ser menor que el precio al detal!',
                        'warning'
                    )
                    $('#precio_detal').val('');
                }
            });

            // Valido que el precio unitario sea menor que el precio al detal
            $('#precio_por_mayor').blur(function() {
                let precioUnitario = parseFloat($('#precio_unitario').val()) || 0;
                let precioDetal = parseFloat($('#precio_detal').val()) || 0;
                let precioPorMayor = parseFloat($('#precio_por_mayor').val()) || 0;

                if (precioPorMayor <= precioUnitario || precioPorMayor >= precioDetal) {
                    Swal.fire(
                        'Cuidado!',
                        'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                        'warning'
                    )
                    $('#precio_por_mayor').val('');
                }
            });

            //======================== Validación de referencia ==============================//

            const referenceInput = document.getElementById('referencia');
            const errorReferenceMsg = document.getElementById('reference-error');

            referenceInput.addEventListener('blur', async () => {
                const reference = referenceInput.value.trim();
                const regexReferencia = /^[a-zA-Z0-9\-_#]{2,50}$/;
                errorReferenceMsg.classList.add('d-none');
                referenceInput.classList.remove('is-invalid');

                if (reference === '') {
                    errorReferenceMsg.textContent = 'Este campo es obligatorio.';
                    errorReferenceMsg.classList.remove('d-none');
                    referenceInput.classList.add('is-invalid');
                    return;
                }

                if (!regexReferencia.test(reference)) {
                    errorReferenceMsg.textContent = 'Ingrese una referencia válida, sin espacios.';
                    errorReferenceMsg.classList.remove('d-none');
                    referenceInput.classList.add('is-invalid');
                    return;
                }

                try
                {
                    const response = await fetch("{{ route('verificar_referencia') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            referencia: reference
                        })
                    });

                    if (!response.ok) throw new Error('Error en la petición');

                    const data = await response.json();

                    if (!data.valido) {
                        errorReferenceMsg.textContent = 'Esta referencia ya está registrada.';
                        referenceInput.value = '';
                        errorReferenceMsg.classList.remove('d-none');
                        referenceInput.classList.add('is-invalid');
                    }
                } catch (error) {
                    console.error('Error al validar la referencia:', error);
                    errorReferenceMsg.textContent = 'Ocurrió un error. Intente más tarde.';
                    errorReferenceMsg.classList.remove('d-none');
                    referenceInput.classList.add('is-invalid');
                }
            });
            //=========================== Fin validación de referencia ==============================//

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formCrearProducto"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // formCrearCategoria para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearProducto']", function(e) {
    
                // PRIMERO validamos los precios. Si falla, paramos el submit.
                if (!validarPreciosCreacion()) {
                    e.preventDefault();
                    return false;
                }

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorCrearProducto']"); // Busca el GIF

                // Dessactivar Submit y Cancel
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                loadingIndicator.show(); // Mostrar Spinner
            });

            // formCrearUmd para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearUmdProducto']", function(e)
            {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorUmdStore']");

                // Mostrar Spinner
                loadingIndicator.show();

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
            });

            // ===========================================================
            document.getElementById('fecha_vencimiento').addEventListener('change', function()
            {
                // Fecha seleccionada por el usuario
                const seleccionada = new Date(this.value);

                // Fecha actual + 8 días
                const hoy = new Date();
                hoy.setHours(0,0,0,0); // limpiar horas
                const fechaEsperada = new Date(hoy);
                fechaEsperada.setDate(hoy.getDate() + 8);

                // Comparación
                if (seleccionada.getTime() < fechaEsperada.getTime())
                {
                    Swal.fire(
                        'Cuidado!',
                        'Se recomienda que la fecha de vencimiento sea mayor a 8 días calendario',
                        'warning'
                    );

                    return;
                }
            });

        }); // FIN document.ready

        // Funcionalidad input tipo file para imagen producto
        function displaySelectedFile(inputId, displayElementId)
        {
            const input = document.getElementById(inputId);
            const displayElement = document.getElementById(displayElementId);
            const file = input.files[0];

            // Reset
            displayElement.textContent = '';
            displayElement.classList.add('hidden');

            if (file)
            {
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

        // function displaySelectedFile(inputId, displayElementId) {
        //     const input = document.getElementById(inputId);
        //     const selectedFile = input.files[0];
        //     const displayElement = document.getElementById(displayElementId);

        //     if (selectedFile) {
        //         const selectedFileName = selectedFile.name;
        //         displayElement.textContent = selectedFileName;
        //         displayElement.classList.remove('hidden');
        //     } else {
        //         displayElement.textContent = '';
        //         displayElement.classList.add('hidden');
        //     }
        // }

        // =======================
        // FUNCIÓN AUXILIAR DE VALIDACIÓN DE PRECIOS
        // =======================
        function validarPreciosCreacion() {
            let precioUnitario = parseFloat($('#precio_unitario').val()) || 0;
            let precioDetal = parseFloat($('#precio_detal').val()) || 0;
            let precioPorMayor = parseFloat($('#precio_por_mayor').val()) || 0;

            // Precio unitario < detal
            if (precioUnitario >= precioDetal) {
                Swal.fire(
                    'Cuidado!',
                    'El precio unitario debe ser menor que el precio al detal!',
                    'warning'
                );
                return false;
            }

            // Unitario < mayor < detal
            if (precioPorMayor <= precioUnitario || precioPorMayor >= precioDetal) {
                Swal.fire(
                    'Cuidado!',
                    'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                    'warning'
                );
                return false;
            }

            return true; // Todo OK
        }
    </script>
@stop
