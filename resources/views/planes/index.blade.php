@extends('layouts.app')
@section('title', 'Planes')

@section('css')
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
            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('planes.create') }}" class="btn text-white" style="background-color:#337AB7">
                        Crear Plan
                    </a>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Listar Planes
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="{{-- table-responsive --}}">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_planes"
                            aria-describedby="users-usuarios">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    <th>Id Plan</th>
                                    <th>Plan</th>
                                    <th>Valor Mensual</th>
                                    <th>Valor Trimestral</th>
                                    <th>Valor Semestral</th>
                                    <th>Valor Anual</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($planesIndex as $plan)
                                    <tr class="text-center align-middle">
                                        <td>{{ $plan->id_plan }}</td>
                                        <td>{{ $plan->nombre_plan }}</td>
                                        <td>{{ $plan->valor_mensual }}</td>
                                        <td>{{ $plan->valor_trimestral }}</td>
                                        <td>{{ $plan->valor_semestral }}</td>
                                        <td>{{ $plan->valor_anual }}</td>
                                        <td>{{ $plan->descripcion_plan }}</td>
                                        <td>{{ $plan->estado }}</td>
                                        <td>
                                            <a href="{{ route('planes.edit', $plan->id_plan) }}"
                                                class="btn btn-success text-white rounded-circle btn-circle btn-editar-plan"
                                                title="Editar Plan">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                // placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            $('.select2').on('select2:open', function (e) {
                // Buscamos el input de búsqueda dentro del contenedor de Select2 y le damos foco
                document.querySelector('.select2-search__field').focus();
            });

            // ===========================================================================================

            // INICIO DataTable Lista Planes
            $("#tbl_planes").DataTable({
                dom: 'Blfrtip',
                infoEmpty: "No hay registros",
                stripe: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
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
                pageLength: 10,
                scrollX: true
            });
            // CIERRE DataTable Lista Planes

            // ===========================================================================================

        }); // FIN document.ready
    </script>
@stop
