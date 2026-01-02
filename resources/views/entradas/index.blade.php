@extends('layouts.app')
@section('title', 'Listar Compras')

@section('css')
    <style>
        .btn-circle {
            padding-left: 0.3rem !important;
            padding-right: 0.3rem !important;
            padding-top: 0.0rem !important;
            padding-bottom: 0.0rem !important;
        }

        /* Oculta el icono de calendario nativo en Chrome, Safari y Edge */
        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
            -webkit-appearance: none;
        }

        /* Oculta el icono en Firefox */
        input[type="date"]::-moz-calendar-picker-indicator {
            display: none;
        }

        /* Para navegadores que aún muestran el ícono nativo */
        input[type="date"] {
            position: relative;
            z-index: 2;
            background-color: transparent;
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
                    <a href="{{ route('entradas.create') }}" class="btn text-white"
                        style="background-color:#337AB7">Registrar Compras</a>
                </div>
            </div>
            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Compras</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_entradas"
                            aria-describedby="entradas">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    {{-- <th>Empresa</th> --}}
                                    <th>Código Compra</th>
                                    <th>Valor Total</th>
                                    <th>Factura Compra</th>
                                    <th>Fecha Compra</th>
                                    <th>Identificación Proveedor</th>
                                    <th>Nombre Proveedor</th>
                                    <th>Comprador</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradas as $entrada)
                                    <tr class="text-center align-middle">
                                        {{-- <td>{{$entrada->empresa}}</td> --}}
                                        <td>{{ $entrada->id_compra }}</td>
                                        <td class="text-end">{{ $entrada->valor_compra }}</td>
                                        <td>{{ $entrada->factura_compra }}</td>
                                        <td>{{ $entrada->fecha_compra }}</td>

                                        @if ($entrada->nit_proveedor)
                                            <td>{{ $entrada->nit_proveedor }}</td>
                                        @else
                                            <td>{{ $entrada->identificacion }}</td>
                                        @endif

                                        @if ($entrada->proveedor_juridico)
                                            <td>{{ $entrada->proveedor_juridico }}</td>
                                        @else
                                            <td>{{ $entrada->nombres_proveedor }} {{ $entrada->apellidos_proveedor }}</td>
                                        @endif

                                        <td>{{ $entrada->nombres_usuario }}</td>

                                        @if ($entrada->id_estado == 1)
                                            <td>
                                                <button title="Ver Detalles"
                                                    class="btn rounded-circle btn-circle text-white btn-detalle-entrada"
                                                    style="background-color: #286090" data-id="{{ $entrada->id_compra }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>

                                                <button title="Anular"
                                                    class="btn rounded-circle btn-circle text-white btn-danger btn-anular-entrada"
                                                    data-id="{{ $entrada->id_compra }}">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <button title="Ver Detalles"
                                                    class="btn rounded-circle btn-circle text-white btn-detalle-entrada"
                                                    style="background-color: #286090" data-id="{{ $entrada->id_compra }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="mt-5 mb-2 d-flex justify-content-center">
                        <button type="submit" class="btn rounded-2 me-3 text-white" style="background-color: #286090"
                            data-bs-toggle="modal" data-bs-target="#modalReporteCompras">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte Compras
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    <!-- {{-- INICIO Modal REPORTE COMPRAS --}}
    <div class="modal fade" id="modalReporteCompras" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="rounded-top" style="border: solid 1px #337AB7;">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['reporte_compras_pdf'],
                        'class' => '',
                        'autocomplete' => 'off',
                        'id' => 'formReporteComprasPdf',
                        'target' => '_blank', // 👉 Abrir en nueva pestaña
                    ]) !!}
                    @csrf

                    <div class="rounded-top text-white text-center"
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h5>Reporte Compras</h5>
                    </div>

                    <div class="modal-body m-0">
                        <div class="row m-0">
                            <div class="col-12 col-md-6">
                                <label for="fecha_inicial" class="fw-bold" style="font-size: 12px">
                                    Fecha Inicial <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" id="calendar_addon_inicial" style="cursor: pointer;">
                                    {!! Form::date('fecha_inicial', null, ['class' => 'form-control', 'id' => 'fecha_inicial', 'required']) !!}
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="fecha_final" class="fw-bold" style="font-size: 12px">
                                    Fecha Final <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" id="calendar_addon_final" style="cursor: pointer;">
                                    {!! Form::date('fecha_final', null, ['class' => 'form-control', 'id' => 'fecha_final', 'required']) !!}
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- FIN modal-body -->

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <!-- <div class="modal-footer border-0 d-flex justify-content-center mt-3">
                        <button type="submit" id="btn_reporte_compras" class="btn btn-success"
                            title="Guardar Configuración">
                            <i class="fa fa-file-pdf-o"> Generar Pdf Compras</i>
                        </button>
                    </div> -->
                    {!! Form::close() !!}
                <!-- </div> {{-- FIN Div rounded-top --}}

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-md active pull-right"
                            style="background-color: #337AB7;" data-bs-dismiss="modal" id="btnReportePrestamos">
                            <i class="fa fa-check-circle"> Aceptar</i>
                        </button>
                    </div>
                </div>
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal REPORTE COMPRAS --}} -->

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}


    {{-- INICIO Modal DETALLE ENTRADA --}}
    <div class="modal fade" id="modalDetalleEntrada" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog" style="min-width: 50%">
            <div class="modal-content p-3" id="modalDetalleEntradaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal DETALLE ENTRADA --}}

    {{-- INICIO Modal ANULAR ENTRADA --}}
    <div class="modal fade" id="modalAnularEntrada" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog" style="min-width: 50%">
            <div class="modal-content p-3" id="modalAnularEntradaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal ANULAR ENTRADA --}}
@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable
            $("#tbl_entradas").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                bSort: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn btn-sm btn-success mr-3',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    }
                ],
                "pageLength": 10,
                "scrollX": true,
                "ordering": false
            }); // CIERRE DataTable

            // =========================================================================

            // formAnularCompra para cargar gif en el submit
            $(document).on("submit", "form[id^='formAnularCompra_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns
                const loadingIndicator = $(`#loadingIndicatorAnularCompra_${id}`);
                const submitButton = $(`#btn_anular_compra_${id}`);
                const cancelButton = $(`#btn_cancelar_compra_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar Spinner
                loadingIndicator.show();
            });

            // =========================================================================
            // =========================================================================
            // =========================================================================

            $(document).on('shown.bs.modal', '#modalReporteCompras', function() {
                let modal = $(this); // Referencia del modal

                function configurarCalendario(inputId, iconoId) {
                    let inputFecha = modal.find(`#${inputId}`);
                    let iconoCalendario = modal.find(`#${iconoId}`);

                    if (inputFecha.length > 0) {
                        // Abre el calendario al hacer clic en el input
                        inputFecha.on("focus", function() {
                            if (typeof this.showPicker === "function") {
                                this.showPicker();
                            }
                        });

                        // Abre el calendario al hacer clic en el icono
                        iconoCalendario.on("mousedown touchstart", function(event) {
                            event.preventDefault();
                            if (typeof inputFecha[0].showPicker === "function") {
                                inputFecha[0].showPicker();
                            }
                        });
                    }
                }

                // Configura ambos campos de fecha dentro del modal
                configurarCalendario("fecha_inicial", "calendar_addon_inicial");
                configurarCalendario("fecha_final", "calendar_addon_final");
            });

            // =========================================================================
            // =========================================================================
            // =========================================================================

            $(document).on('click', '.btn-detalle-entrada', function() {
                const idEntrada = $(this).data('id');

                $.ajax({
                    url: `detalleEntrada/${idEntrada}`,
                    type: 'GET',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'detalle_compra'
                    },
                    beforeSend: function() {
                        $('#modalDetalleEntradaContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                        $('#modalDetalleEntrada').modal('show');
                    },
                    success: function(html) {
                        $('#modalDetalleEntradaContent').html(html);
                        $('#modalDetalleEntrada').modal('show');

                        // Inicializar DataTable después de un pequeño retraso para asegurar que esté en el DOM
                        setTimeout(function() {
                            const tableId = `#tblDetalleCompraProductos_${idEntrada}`;

                            if ($.fn.DataTable.isDataTable(tableId)) {
                                $(tableId).DataTable().clear()
                            .destroy(); // Previene doble inicialización
                            }

                            let tableDetalles = $(tableId).DataTable({
                                dom: 'lrtip',
                                infoEmpty: 'No hay registros',
                                stripe: true,
                                bSort: false,
                                autoWidth: false,
                                scrollX: true,
                                pageLength: 10,
                                responsive: true
                            });

                            tableDetalles.columns.adjust();

                        }, 100);
                    },
                    error: function() {
                        $('#modalDetalleEntradaContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });

            // =========================================================================
            // =========================================================================
            // =========================================================================

            $(document).on('click', '.btn-anular-entrada', function() {
                const idEntrada = $(this).data('id');

                $.ajax({
                    url: `detalleEntrada/${idEntrada}`,
                    type: 'GET',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'anular_compra'
                    },
                    beforeSend: function() {
                        $('#modalAnularEntradaContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                        $('#modalAnularEntrada').modal('show');
                    },
                    success: function(html) {
                        $('#modalAnularEntradaContent').html(html);
                    },
                    error: function() {
                        $('#modalAnularEntradaContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });
        }); // FIN document.ready
    </script>
@stop
