@extends('layouts.app')
@section('title', 'Auditorias')

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

            <div class="page-title-modern">
                <i class="fa fa-tags"></i>
                <span>Gestionar Auditorias</span>
            </div>

            <div class="d-flex flex-column flex-lg-row gap-3 categorias-panels">
                

                <div class="card-modern flex-grow-1">
                    <div class="card-modern-header">
                        <i class="fa fa-list"></i>
                        <span>Listar Auditorias</span>
                    </div>

                    <div class="p-3">
                        <table class="table table-modern w-100 mb-0" id="tbl_auditorias" aria-describedby="auditorias">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Nombre Usuario</th>
                                    <th>Empresa</th>
                                    <th>Evento</th>
                                    <th>Tipo Auditable</th>
                                    <th>ID Auditable</th>
                                    <th>Valores Antiguos</th>
                                    <th>Valores Nuevos</th>
                                    <th>URL</th>
                                    <th>IP</th>
                                    <th>Agente Usuario</th>
                                    <th>Tags</th>
                                    <th>Fecha Creación</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_ --}}
            </div>
        </div>
    </div>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

  
    
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Auditorias
            $("#tbl_auditorias").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('auditorias.datos') }}",
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                scrollX: true,
                ordering: false,
                searching: false,
                dom: 'Blfrtip',
                columns: [
                    { data: "id" },
                    { data: "user_id" },
                    { data: "nombre_usuario" },
                    { data: "nombre_empresa" },
                    { data: "event" },
                    { data: "auditable_type" },
                    { data: "auditable_id" },
                    { data: "old_values" },
                    { data: "new_values" },
                    { data: "url" },
                    { data: "ip_address" },
                    { data: "user_agent" },
                    { data: "tags" },
                    { data: "created_at" }
                ],
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-modern-excel mr-3',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    }
                ],
                language: {
                    processing: "Cargando...",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "No hay registros",
                    lengthMenu: "Mostrar _MENU_",
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                }
            });
            // CIERRE DataTable Lista Auditorias
        });
    </script>
@stop