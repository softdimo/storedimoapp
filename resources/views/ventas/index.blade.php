@extends('layouts.app')
@section('title', 'Ventas')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

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

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <a href="{{ route('ventas.create') }}" class="btn text-white" style="background-color:#337AB7">Registrar
                        Ventas</a>
                </div>
            </div>
            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Ventas</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_ventas"
                            aria-describedby="ventas">
                            <thead>
                                <tr class="header-table text-centerr align-middle">
                                    <th>Código</th>
                                    <th>Total Venta</th>
                                    <th>Ganancia</th>
                                    <th>Fecha Registro Venta</th>
                                    <th>Identificación Cliente</th>
                                    <th>Nombre Cliente</th>
                                    <th>Tipo Pago</th>
                                    <th>Vendedor</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr class="text-center align-middle">
                                        <td>{{ $venta->id_venta }}</td>
                                        <td class="text-end">{{ $venta->total_venta_index }}</td>
                                        <td class="text-end">{{ $venta->ganancia_total_venta }}</td>
                                        <td>{{ $venta->fecha_venta }}</td>
                                        <td>{{ $venta->identificacion }}</td>
                                        <td>{{ $venta->nombres_cliente }}</td>
                                        <td>{{ $venta->tipo_pago }}</td>
                                        <td>{{ $venta->nombres_usuario }}</td>
                                        <td>
                                            <button title="Ver Detalles"
                                                class="btn rounded-circle btn-circle text-white btn-detalle-venta"
                                                title="Detalles Ventas" style="background-color: #286090"
                                                data-id="{{ $venta->id_venta }}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <!-- <div class="mt-5 mb-2 d-flex justify-content-center">
                        <button type="submit" class="btn rounded-2 me-3 text-white" style="background-color: #286090"
                            data-bs-toggle="modal" data-bs-target="#modalReporteVentas">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte Ventas
                        </button>
                    </div> -->
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div>
    </div>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    <!-- {{-- INICIO Modal REPORTE VENTAS --}}
    <div class="modal fade" id="modalReporteVentas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="rounded-top" style="border: solid 1px #337AB7;">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['reporte_ventas_pdf'],
                        'class' => '',
                        'autocomplete' => 'off',
                        'id' => 'formReporteVentasPdf',
                        'target' => '_blank', // 👉 Abrir en nueva pestaña
                    ]) !!}
                    @csrf

                    <div class="rounded-top text-white text-center"
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h5>Reporte Ventas</h5>
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
                        <button type="submit" id="btn_reporte_ventas" class="btn btn-success">
                            <i class="fa fa-file-pdf-o"> Generar Pdf Ventas</i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div> {{-- FIN Div rounded-top --}}

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-md active pull-right"
                            style="background-color: #337AB7;" data-bs-dismiss="modal" id="btnReporteVentas">
                            <i class="fa fa-check-circle"> Aceptar</i>
                        </button>
                    </div>
                </div>
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}} -->
    {{-- FINAL Modal REPORTE VENTAS --}}

    {{-- INICIO Modal DETALLE BAJA --}}
    <div class="modal fade" id="modalDetalleVenta" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog" style="min-width: 50%">
            <div class="modal-content p-3" id="modalDetalleVentaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal DETALLE BAJA --}}


@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Usuarios
            $("#tbl_ventas").DataTable({
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
            });
            // CIERRE DataTable Lista Usuarios

            $('[id^=modalDetalleVenta_]').on('shown.bs.modal', function() {
                const modalId = $(this).attr('id');
                const idVenta = modalId.replace('modalDetalleVenta_', '');
                const tableId = `#tblDetalleVentaProductos_${idVenta}`;

                // Evitar reinicialización
                if (!$.fn.DataTable.isDataTable(tableId)) {
                    $(tableId).DataTable({
                        // dom: 'Blfrtip',
                        dom: 'lrtip', // sin botones, solo length, table, info, pagination
                        infoEmpty: 'No hay registros',
                        stripe: true,
                        bSort: false,
                        autoWidth: false,
                        scrollX: true,
                        pageLength: 10
                    });
                } else {
                    // Solo ajustar columnas si ya está inicializado
                    $(tableId).DataTable().columns.adjust();
                }
            });

            // =========================================================================
            // =========================================================================
            // =========================================================================

            $(document).on('shown.bs.modal', '#modalReporteVentas', function() {
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

                        // Evento para asegurarse de que la fecha se refleje
                        inputFecha.on("change", function() {
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

            $(document).on('click', '.btn-detalle-venta', function() {
                const idVenta = $(this).data('id');

                $.ajax({
                    url: `detalle_venta/${idVenta}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#modalDetalleVentaContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                            );
                        $('#modalDetalleVenta').modal('show');
                    },
                    success: function(html) {
                        $('#modalDetalleVentaContent').html(html);
                        $('#modalDetalleVenta').modal('show');

                        setTimeout(function() {
                            const tableId = `#tblDetalleVentaProductos_${idVenta}`;
                            if ($.fn.DataTable.isDataTable(tableId)) {
                                $(tableId).DataTable().clear().destroy();
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

                        // Asignar evento al botón que se acaba de insertar en el DOM
                        const btn = document.getElementById(`btnReciboVenta_${idVenta}`);
                        if (btn) {
                            btn.addEventListener("click", function() {
                                let venta = {
                                    id: this.dataset.id,
                                    fecha: this.dataset.fecha,
                                    usuario: this.dataset.usuario,
                                    cliente: this.dataset.cliente,
                                    subtotal: this.dataset.subtotal,
                                    descuento: this.dataset.descuento,
                                    total: this.dataset.total,
                                    detalles: JSON.parse(this.dataset.detalles)
                                };

                                const spinner = document.getElementById(
                                    `loadingIndicatorReciboVenta_${venta.id}`);
                                const btnCancelar = document.getElementById(
                                    `btnCancelarReciboVenta_${venta.id}`);
                                const btnGenerar = this;
                                const originalContent = btnGenerar.innerHTML;

                                if (spinner) spinner.style.display = 'block';
                                btnGenerar.disabled = true;
                                btnGenerar.innerHTML =
                                    `Procesando... <i class="fa fa-spinner fa-spin"></i>`;
                                if (btnCancelar) btnCancelar.disabled = true;

                                fetch("/recibo_caja_venta", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": document.querySelector(
                                                    'meta[name="csrf-token"]')
                                                .getAttribute("content")
                                        },
                                        body: JSON.stringify(venta)
                                    })
                                    .then(response => response.blob())
                                    .then(blob => {
                                        if (spinner) spinner.style.display = 'none';
                                        btnGenerar.disabled = false;
                                        btnGenerar.innerHTML = originalContent;
                                        if (btnCancelar) btnCancelar.disabled =
                                            false;

                                        let url = window.URL.createObjectURL(blob);
                                        window.open(url, "_blank");
                                    })
                                    .catch(error => {
                                        if (spinner) spinner.style.display = 'none';
                                        btnGenerar.disabled = false;
                                        btnGenerar.innerHTML = originalContent;
                                        if (btnCancelar) btnCancelar.disabled =
                                            false;
                                        console.error("Error al generar PDF:",
                                            error);
                                    });
                            });
                        }
                    },

                    error: function() {
                        $('#modalDetalleVentaContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                            );
                    }
                });
            });
        }); // FIN document.ready
    </script>
@stop
