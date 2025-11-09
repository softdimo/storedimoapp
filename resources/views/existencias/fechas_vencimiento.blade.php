@extends('layouts.app')
@section('title', 'Productos Próximo a Vencer')

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
                    Productos Próximos Vencer o Vencidos</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_fechas_vencimiento"
                            aria-describedby="fechas_vencimiento">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Referencia</th>
                                    <th>Nombre Producto</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($fechasVencimientoIndex as $fechaVencimiento)
                                    <tr class="text-center">
                                        <td>{{ $fechaVencimiento->referencia }}</td>
                                        <td>{{ $fechaVencimiento->nombre_producto }}</td>
                                        <td>{{ $fechaVencimiento->categoria }}</td>
                                        <td>{{ $fechaVencimiento->descripcion }}</td>
                                        <td>{{ $fechaVencimiento->fecha_vencimiento }}</td>
                                        <td>{{ $fechaVencimiento->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable stock Mínimo
            $("#tbl_fechas_vencimiento").DataTable({
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
                        title: 'Productos Próximos a Vencer',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        customize: function(doc) {
                            const columnCount = $('#tbl_fechas_vencimiento thead th').length;
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
        }); // FIN document.ready
    </script>
@stop
