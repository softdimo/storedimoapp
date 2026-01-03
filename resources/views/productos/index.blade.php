@extends('layouts.app')
@section('title', 'Productos')
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <style>
        .btn-circle {
            padding-left: 0.3rem !important;
            padding-right: 0.3rem !important;
            padding-top: 0.0rem !important;
            padding-bottom: 0.0rem !important;
        }
    </style>
@stop

@section('content')
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <a href="{{ route('productos.create') }}" class="btn text-white" style="background-color:#337AB7">Crear
                        Producto</a>
                </div>

                <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                    data-bs-target="#modalAyudaModificacionProductos">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div>

            <div class="modal fade" id="modalAyudaModificacionProductos" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 85%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Listar Productos</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario en esta vista usted se va a encontrar con
                                            diferentes
                                            opciones ubicadas al lado izquierdo de la tabla, cada una con una acción
                                            diferente, esas opciones son:
                                        </p>

                                        <ul>
                                            <li><strong>Opcion de Modificación:</strong>
                                                <ol>Tener en cuenta a la hora de modificar un producto lo siguiente:
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian,
                                                        el sistema no le dejará seguir.</li>
                                                    <li class="text-justify">Evitar ingresar nombres de productos ya
                                                        existentes.</li>
                                                    <li class="text-justify">El precio unitario no puede ser mayor al precio
                                                        al detal y precio al por mayor.</li>
                                                    <li class="text-justify">El precio al detal no puede ser menor al precio
                                                        al por mayor.</li>
                                                </ol>
                                                <br>
                                            </li>
                                            <li><strong>Opción de Generación Código de Barras:</strong>
                                                <ol>Tener en cuenta lo siguiente en el momento de generar el código de
                                                    barras de un producto:
                                                    <li class="text-justify">En el campo de cantidad la longitud máxima
                                                        permitida es de 3 caracteres.</li>
                                                    <li class="text-justify">Ingresar cantidades no mayores a 100.</li>
                                                </ol>
                                            </li>
                                        </ul>
                                        <p class="text-justify mb-0">El icono de color azul es de solo información.</p>
                                        <p class="text-justify mt-0 mb-0">El icono rojo pertenece al cambio de estado, el
                                            cual pedirá
                                            confirmación en el momento de pulsar sobre el.</p>
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

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Productos</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_productos"
                            aria-describedby="productos">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    {{-- <th>Código</th> --}}
                                    <th class="align-middle">Referencia</th>
                                    <th class="align-middle">Imagen</th>
                                    <th class="align-middle">Nombre Producto</th>
                                    <th class="align-middle">Categoría</th>
                                    <th class="align-middle">Descripción</th>
                                    <th class="align-middle">Proveedor</th>
                                    <th class="align-middle">Cantidad</th>
                                    <th class="align-middle">Stock Mínimo</th>
                                    <th class="align-middle">Fecha Vencimiento</th>
                                    <th class="align-middle">Estado Vencimiento</th>
                                    <th class="align-middle">Unidad de Medida</th>
                                    <th class="align-middle">Estado</th>
                                    <th class="align-middle">Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr class="text-center align-middle">
                                        {{-- <td>{{ $producto->id_producto }}</td> --}}
                                        <td class="align-middle">{{ $producto->referencia }}</td>

                                        @if (is_null($producto->imagen_producto))
                                            <td class="align-middle"></td>
                                        @else
                                            <td class="align-middle">
                                                <img src="{{ $producto->imagen_producto }}" alt="Producto"
                                                    style="max-width: 50px;">
                                            </td>
                                        @endif

                                        <td class="align-middle">{{ $producto->nombre_producto }}</td>
                                        <td class="align-middle">{{ $producto->categoria }}</td>
                                        <td class="align-middle">{{ $producto->descripcion }}</td>
                                        <td class="align-middle">{{ $producto->nombres_proveedor }}</td>

                                        @if (is_null($producto->cantidad))
                                            <td class="bg-warning-subtle align-middle">Sin compra realizada</td>
                                        @elseif ($producto->cantidad <= $producto->stock_minimo)
                                            <td class="bg-danger-subtle align-middle">{{ $producto->cantidad }}</td>
                                        @else
                                            <td class="bg-success-subtle align-middle">{{ $producto->cantidad }}</td>
                                        @endif

                                        <td class="align-middle">{{ $producto->stock_minimo }}</td>

                                        @if(is_null($producto->fecha_vencimiento) || $producto->fecha_vencimiento == "")
                                            <td class="align-middle">No Aplica</td>
                                        @else
                                            <td class="align-middle">{{ $producto->fecha_vencimiento }}</td>
                                        @endif

                                        @if (!empty($producto->estado_vencimiento))
                                            @if ($producto->estado_vencimiento === 'vencido')
                                                <td class="bg-danger-subtle text-danger fw-semibold align-middle">
                                                    {{ ucfirst($producto->estado_vencimiento) }}
                                                </td>
                                            @elseif ($producto->estado_vencimiento === 'próximo a vencer')
                                                <td class="bg-warning-subtle text-warning fw-semibold align-middle">
                                                    {{ ucfirst($producto->estado_vencimiento) }}
                                                </td>
                                            @elseif ($producto->estado_vencimiento === 'vigente')
                                                <td class="bg-success-subtle text-success fw-semibold align-middle">
                                                    {{ ucfirst($producto->estado_vencimiento) }}
                                                </td>
                                            @else
                                                <td class="align-middle">{{ $producto->estado_vencimiento }}</td>
                                            @endif
                                        @else
                                            <td class="align-middle">—</td>
                                        @endif

                                        <td class="align-middle">{{ $producto->umd }}</td>
                                        <td class="align-middle">{{ $producto->estado }}</td>

                                        @if ($producto->id_estado == 1 || $producto->id_estado == '1')
                                            <td class="align-middle">
                                                <button
                                                    class="btn btn-success rounded-circle btn-circle btn-editar-producto"
                                                    data-id="{{ $producto->id_producto }}" title="Modificar">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                {{-- ============================== --}}
                                                <button
                                                    class="btn btn-warning rounded-circle btn-circle barcode btn-codigo-barras"
                                                    data-id="{{ $producto->id_producto }}"
                                                    title="Generar Código de Barras">
                                                    <i class="fa fa-barcode"></i>
                                                </button>
                                                {{-- ============================== --}}
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado"
                                                    data-id="{{ $producto->id_producto }}" title="Cambiar Estado">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td class="align-middle">
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado"
                                                    data-id="{{ $producto->id_producto }}" title="Cambiar Estado">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (session('pdfUrl'))
                        <script>
                            window.open("{{ session('pdfUrl') }}", "_blank");
                        </script>
                    @endif

                    <!-- <div class="mt-5 mb-2 d-flex justify-content-center">
                            <a href="{{ route('reporte_productos_pdf') }}" target="_blank"
                                class="btn rounded-2 me-3 text-white" style="background-color: #286090">
                                <i class="fa fa-file-pdf-o"></i>
                                Reporte Productos
                            </a>
                        </div> -->
                </div> {{-- FIN div_ --}}
            </div> {{-- FIN div_ --}}
        </div>
    </div>

    {{-- INICIO Modal MODIFICAR PRODUCTO --}}
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog" style="min-width: 50%">
            <div class="modal-content p-3" id="modalEditarProductoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal MODIFICAR PRODUCTO --}}

    {{-- INICIO Modal CÓDIGO DE BARRAS PRODUCTO --}}
    <div class="modal fade" id="modalBarCodeProducto" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalBarCodeProductoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal CÓDIGO DE BARRAS PRODUCTO --}}

    {{-- INICIO Modal ESTADO PRODUCTO --}}
    <div class="modal fade" id="modalCambiarEstadoProducto" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalCambiarEstadoProductoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal ESTADO PRODUCTO --}}
@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // @if (isset($productos) && count($productos) > 0)
            // INICIO DataTable Lista Productos
            $("#tbl_productos").DataTable({
                ordering: false,
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                bSort: true,
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-sm btn-success mr-3',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr('s', '42');
                    }
                }],
                "pageLength": 10,
                "scrollX": true,
            });
            // @endif
            // CIERRE DataTable Lista Productos

            // ===========================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formEditarProducto_"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            $(document).on('click', '.btn-editar-producto', function() {
                const idProducto = $(this).data('id');

                $.ajax({
                    url: `producto_edit/${idProducto}`,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'editar'
                    },
                    beforeSend: function() {
                        $('#modalEditarProducto').modal('show');
                        $('#modalEditarProductoContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalEditarProductoContent').html(html);

                        // Reinicializar select2 si lo usas en el modal
                        $('#modalEditarProducto .select2').select2({
                            dropdownParent: $('#modalEditarProducto'),
                            placeholder: 'Seleccionar...',
                            width: '100%',
                            allowClear: false
                        });

                        // Buscar los elementos dentro de este modal
                        let modal = $('#modalEditarProducto');
                        let inputPrecioUnitario = modal.find('[id^=precioUnitarioEdit]');
                        let inputPrecioDetal = modal.find('[id^=precioDetalEdit]');
                        let inputPrecioPorMayor = modal.find('[id^=precioPorMayorEdit]');

                        if (inputPrecioUnitario.length > 0) {
                            // Asignar validaciones en blur usando la función auxiliar
                            inputPrecioDetal.on("blur", function() {
                                validarPrecios(modal);
                            });

                            inputPrecioPorMayor.on("blur", function() {
                                validarPrecios(modal);
                            });
                        }

                        // if (inputPrecioUnitario.length > 0) { // Al cargar el modal
                            // Valido que el precio unitario sea menor que el precio al detal
                            // inputPrecioDetal.on("blur", function() {
                            //     let precioUnitario = parseFloat(inputPrecioUnitario
                            //         .val()) || 0;
                            //     let precioDetal = parseFloat(inputPrecioDetal.val()) ||
                            //         0;

                            //     if (precioUnitario >= precioDetal) {
                            //         Swal.fire(
                            //             'Cuidado!',
                            //             'El precio unitario debe ser menor que el precio al detal!',
                            //             'warning'
                            //         )
                            //         inputPrecioDetal.val('');
                            //     }
                            // });

                            // ===================================================

                            // Valido que el precio por mayor sea mayor que el unitario y menor que el precio al detal
                            // inputPrecioPorMayor.blur(function() {
                            //     let precioUnitario = parseFloat(inputPrecioUnitario
                            //         .val()) || 0;
                            //     let precioDetal = parseFloat(inputPrecioDetal.val()) ||
                            //         0;
                            //     let precioPorMayor = parseFloat(inputPrecioPorMayor
                            //         .val()) || 0;

                            //     if (precioPorMayor <= precioUnitario ||
                            //         precioPorMayor >= precioDetal) {
                            //         Swal.fire(
                            //             'Cuidado!',
                            //             'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                            //             'warning'
                            //         )
                            //         inputPrecioPorMayor.val('');
                            //     }
                            // });
                        // } // FIN inputPrecioUnitario.length > 0
                    },
                    error: function() {
                        $('#modalEditarProductoContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                            );
                    }
                });
            });

            // ===========================================================
            // ===========================================================

            // formEditarProducto para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditarProducto_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                const modal = $('#modalEditarProducto');

                // ======= LLAMAR VALIDACIÓN ANTES DEL SPINNER =======
                if (!validarPrecios(modal)) {
                    e.preventDefault();
                    return false;
                }
                // ====================================================

                // Capturar spinner y btns
                const loadingIndicator = $(`#loadingIndicatorEditProducto_${id}`);
                const submitButton = $(`#btn_editar_producto_${id}`);
                const cancelButton = $(`#btn_cancelar_producto_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);
                loadingIndicator.show();
            });

            // ===========================================================
            // ===========================================================

            $(document).on('click', '.btn-cambiar-estado', function() {
                const idProducto = $(this).data('id');

                $.ajax({
                    url: `producto_edit/${idProducto}`,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'estado'
                    },
                    beforeSend: function() {
                        $('#modalCambiarEstadoProducto').modal('show');
                        $('#modalCambiarEstadoProductoContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalCambiarEstadoProductoContent').html(html);
                    },
                    error: function() {
                        $('#modalCambiarEstadoProductoContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });

            // ===========================================================
            // ===========================================================

            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formCambiarEstadoProducto_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEstadoProducto_${id}`);
                const submitButton = $(`#btn_cambiar_estado_producto_${id}`);
                const cancelButton = $(`#btn_cancelar_estado_producto_${id}`);

                // Deshabilitar btns
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar spinner
                loadingIndicator.show();
            });

            // ===========================================================
            // ===========================================================

            $(document).on('click', '.btn-codigo-barras', function() {
                const idProducto = $(this).data('id');

                $.ajax({
                    url: `producto_edit/${idProducto}`,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'qr'
                    },
                    beforeSend: function() {
                        $('#modalBarCodeProducto').modal('show');
                        $('#modalBarCodeProductoContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalBarCodeProductoContent').html(html);
                    },
                    error: function() {
                        $('#modalBarCodeProductoContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });

            // ===========================================================
            // ===========================================================

            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formProductoBarcode_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns dinámicamente
                const submitButton = $(`#btn_codebar_producto_${id}`);
                const cancelButton = $(`#btn_cancelar_codebar_${id}`);
                const loadingIndicator = $(`#loadingIndicatorCodeBarProducto_${id}`);

                // Deshabilitar btns
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar spinner
                loadingIndicator.show();

                // ReadOnly para input de cantidad de barcodes a generar
                const cantidadBarcode = $(`#cantidad_barcode_${id}`).prop("readonly", true);
            });

            // ===========================================================
            // ===========================================================

            // Abre automáticamente el archivo con los códigos QR del producto recién solicitado
            // let pdfUrl = "{{ session('pdfUrl') }}";
            // if (pdfUrl) {
            //     window.open(pdfUrl, '_blank');
            // }
        }); //FIN Document.ready

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

        // ============================================================
        // FUNCIÓN AUXILIAR DE VALIDACIÓN PARA EDITAR PRODUCTO
        // ============================================================
        function validarPrecios(modal) {

            let inputPrecioUnitario = modal.find('[id^=precioUnitarioEdit]');
            let inputPrecioDetal = modal.find('[id^=precioDetalEdit]');
            let inputPrecioPorMayor = modal.find('[id^=precioPorMayorEdit]');

            let precioUnitario = parseFloat(inputPrecioUnitario.val()) || 0;
            let precioDetal = parseFloat(inputPrecioDetal.val()) || 0;
            let precioPorMayor = parseFloat(inputPrecioPorMayor.val()) || 0;

            // Validación #1
            if (precioUnitario >= precioDetal) {
                Swal.fire(
                    'Cuidado!',
                    'El precio unitario debe ser menor que el precio al detal!',
                    'warning'
                );
                return false;
            }

            // Validación #2
            if (precioPorMayor <= precioUnitario || precioPorMayor >= precioDetal) {
                Swal.fire(
                    'Cuidado!',
                    'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                    'warning'
                );
                return false;
            }

            return true;
        }
    </script>
@stop
