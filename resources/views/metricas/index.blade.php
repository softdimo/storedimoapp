@extends('layouts.app')
@section('title', 'Métricas')

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

            {{-- <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarClientes">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div> --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Listar Métricas
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_metricas" aria-describedby="métricas">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    <th>Id Log</th>
                                    <th>Tenant Db</th>
                                    <th>Source</th>
                                    <th>Method</th>
                                    <th>Path</th>
                                    <th>Ip</th>
                                    <th>Status Code</th>
                                    <th>User Agent</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @php
                                    // Si llega como string, lo convertimos en array vacío aquí mismo
                                    if (is_string($metricasIndex)) {
                                        $metricasIndex = [];
                                    }
                                @endphp

                                @forelse ($metricasIndex as $metrica)
                                    <tr class="text-center align-middle">
                                        <td>{{ $metrica->id_log }}</td>
                                        <td>{{ $metrica->tenant_db }}</td>
                                        <td>{{ $metrica->source }}</td>
                                        <td>{{ $metrica->method }}</td>
                                        <td>{{ $metrica->path }}</td>
                                        <td>{{ $metrica->ip }}</td>
                                        <td>{{ $metrica->status_code }}</td>
                                        <td>{{ $metrica->user_agent }}</td>
                                        <td>{{ $metrica->created_at }}</td>
                                        <td>{{ $metrica->updated_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No hay métricas registradas o la API no respondió correctamente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div --}}
            </div> {{-- FIN div --}}
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- ========================================================= --}}

    {{-- INICIO Modal EDITAR CLIENTE --}}
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="min-width: 60%">
            <div class="modal-content p-3" id="modalEditarClienteContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- modal-content --}}
        </div> {{-- modal-dialog --}}
    </div>
    {{-- FINAL Modal EDITAR PROVEEDOR --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Clientes
            $("#tbl_metricas").DataTable({
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
                "pageLength": 25,
                "scrollX": true,
            });
            // CIERRE DataTable Lista Clientes

            // ===========================================================================================

            $(document).on('select2:open', function(e) {
                // Buscamos el campo de texto dentro del contenedor de select2 que se acaba de abrir
                setTimeout(function() {
                    const searchField = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 50);
            });
        }); // FIN document.ready
    </script>
@stop
