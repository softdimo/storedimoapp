@extends('layouts.app')
@section('title', 'Productos stock Mínimo')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

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
            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Productos en Stock Mínimo</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_stock_minimo"
                            aria-describedby="stock_minimo">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Referencia</th>
                                    <th>Nombre Producto</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Stock Mínimo</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($stockMinimoIndex as $stockMinimo)
                                    <tr class="text-center">
                                        <td>{{ $stockMinimo->referencia }}</td>
                                        <td>{{ $stockMinimo->nombre_producto }}</td>
                                        <td>{{ $stockMinimo->categoria }}</td>
                                        <td>{{ $stockMinimo->descripcion }}</td>
                                        <td>{{ $stockMinimo->cantidad }}</td>
                                        <td>{{ $stockMinimo->stock_minimo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="loader-pdf" style="display:none;" class="text-center mt-3">
                    <i class="fa fa-spinner fa-spin text-danger fw-bold"></i>
                    <span class="text-danger fw-bold"> Generando PDF, por favor espera...</span>
                </div>

                <div class="d-flex justify-content-center mt-3 mb-3">
                    <button class="btn btn-success generar-pdf" style="background-color: #337AB7" {{ count($stockMinimoIndex) == 0 ? 'disabled' : '' }}>
                        <i class="fa fa-file-pdf-o"></i> Reporte stock Mínimo
                    </button>
                </div>
            </div> {{-- FIN div_crear_usuario --}}
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable stock Mínimo
            $("#tbl_stock_minimo").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                bSort: true,
                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        className: 'btn btn-sm btn-danger',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Productos en Stock Mínimo',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        customize: function(doc) {
                            const columnCount = $('#tbl_stock_minimo thead th').length;
                            doc.pageSize = 'A5';
                            doc.defaultStyle.fontSize = 12;
                        }
                    },
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
            });
            // CIERRE DataTable stock Mínimo

            // =========================================================================
            // =========================================================================
            // =========================================================================

            document.querySelector(".generar-pdf").addEventListener("click", function() {
            //function generarPDFStockMinimo() {
                let loader = document.getElementById("loader-pdf");
                loader.style.display = "block";
                let productos = [];

                document.querySelectorAll("#tbl_stock_minimo tbody tr").forEach(row => {
                    let producto = {
                        id: row.cells[0].textContent,
                        producto: row.cells[1].textContent,
                        categoria: row.cells[2].textContent,
                        descripcion: row.cells[3].textContent,
                        cantidad: row.cells[4].textContent,
                        stock_minimo: row.cells[5].textContent
                    };
                    productos.push(producto);
                });

                fetch("/stock_minimo_pdf", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            productos
                        }) // Enviamos un array de productos
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        let url = window.URL.createObjectURL(blob);
                        window.open(url, "_blank");
                    })
                    .catch(error => console.error("Error al generar PDF:", error))
                    .finally(() => {
                        loader.style.display = "none"; // Ocultar loader siempre
                    });
            });
        }); // FIN document.ready
    </script>
@stop
