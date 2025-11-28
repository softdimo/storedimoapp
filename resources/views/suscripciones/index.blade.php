@extends('layouts.app')
@section('title', 'Suscripciones')

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
            <div class="d-flex justify-content-end pe-0 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('suscripciones.create') }}" class="btn text-white" style="background-color:#337AB7">
                        Crear Suscripción
                    </a>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Listar Suscripciones
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="{{-- table-responsive --}}">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_suscripciones"
                            aria-describedby="users-usuarios">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Id Suscripción</th>
                                    <th>Empresa</th>
                                    <th>Plan</th>
                                    <th>Días Trial</th>
                                    <th>Modalidad Suscripción</th>
                                    <th>valor_suscripcion</th>
                                    <th>Fecha Inicial</th>
                                    <th>Fecha Final</th>
                                    <th>Estado</th>
                                    <th>Fecha Cancelación</th>
                                    <th>Renovación Automática</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($suscripcionesIndex as $suscripcion)
                                    <tr class="text-center">
                                        <td>{{ $suscripcion->id_suscripcion }}</td>
                                        <td>{{ $suscripcion->nombre_empresa }}</td>
                                        <td>{{ $suscripcion->nombre_plan }}</td>
                                        <td>{{ $suscripcion->dias_trial }}</td>
                                        <td>{{ $suscripcion->modalidad_suscripcion }}</td>
                                        <td>{{ $suscripcion->fecha_inicial }}</td>
                                        <td>{{ $suscripcion->fecha_final }}</td>
                                        <td>{{ $suscripcion->estado }}</td>
                                        <td>{{ $suscripcion->fecha_cancelacion }}</td>
                                        <td>{{ $suscripcion->renovacion_automatica }}</td>
                                        <td>{{ $suscripcion->observaciones_suscripcion }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-success rounded-circle btn-circle btn-editar-suscripcion"
                                                title="Editar Suscripción" data-id="{{ $suscripcion->id_suscripcion }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>ç
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

            // INICIO DataTable Lista Usuarios
            $("#tbl_suscripciones").DataTable({
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
            // CIERRE DataTable Lista Usuarios
        }); // FIN document.ready
    </script>
@stop
