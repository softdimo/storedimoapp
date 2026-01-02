@extends('layouts.app')
@section('title', 'Empresas')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    <style>

    </style>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    @php
        use Illuminate\Support\Facades\Crypt;
    @endphp

    <div id="modal-overlay"></div>
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('empresas.create') }}" class="btn text-white" style="background-color:#337AB7">Crear
                        Empresa</a>
                </div>
                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarEmpresas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="modal fade" id="modalAyudaListarEmpresas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 75%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-5"><strong>Ayuda de Listar Empresas</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario en esta vista usted se va a encontrar con
                                            diferentes opciones ubicadas al lado izquierdo de la tabla, cada una con una
                                            acción diferente, esas opciones son:
                                        </p>

                                        <ul>
                                            <li><strong>Opcion de Modificación:</strong>
                                                <ol>Tener en cuenta a la hora de modificar una empresa lo siguiente:
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian,
                                                        el sistema no le dejará seguir.</li>
                                                    <li class="text-justify">Los campos nombre de empresa e email no pueden
                                                        ser idénticos a datos ya registrados.</li>
                                                </ol>
                                                <br>
                                            </li>
                                        </ul>
                                        <p class="text-justify">Por seguridad el empleado rol administrador no se le
                                            permitirá el cambio de estado</p>
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

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Empresas
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="{{-- table-responsive --}}">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_empresas"
                            aria-describedby="empresas">
                            <thead>
                                <tr class="header-table text-centerr align-middle">
                                    <th>Nit Empresa</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                    <th>Dirección</th>
                                    <th>DB CONNECTION</th>
                                    <th>DB HOST</th>
                                    <th>DB DATABASE</th>
                                    <th>DB USERNAME</th>
                                    <th>DB PASSWORD</th>
                                    <th>LOGO</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($empresas as $empresa)
                                    <tr class="text-centerr align-middle">
                                        <td>{{ $empresa->nit_empresa }}</td>
                                        <td>{{ $empresa->nombre_empresa }}</td>
                                        <td>{{ $empresa->telefono_empresa }}</td>
                                        <td>{{ $empresa->celular_empresa }}</td>
                                        <td>{{ $empresa->email_empresa }}</td>
                                        <td>{{ $empresa->direccion_empresa }}</td>
                                        <td>{{ $empresa->tipo_bd ? $empresa->tipo_bd : '' }}</td>
                                        <td>{{ $empresa->db_host ? Crypt::decrypt($empresa->db_host) : '' }}</td>
                                        <td>{{ $empresa->db_database ? Crypt::decrypt($empresa->db_database) : '' }}</td>
                                        <td>{{ $empresa->db_username ? Crypt::decrypt($empresa->db_username) : '' }}</td>
                                        <td>{{ $empresa->db_password ? Crypt::decrypt($empresa->db_password) : '' }}</td>

                                        @if (is_null($empresa->logo_empresa))
                                            <td class="align-middle"></td>
                                        @else
                                            <td class="align-middle">
                                                <img src="{{ $empresa->logo_empresa }}" alt="Empresa"
                                                    style="max-width: 50px;">
                                            </td>
                                        @endif

                                        <td>{{ $empresa->estado ? $empresa->estado : '' }}</td>
                                        <td>
                                            <a href="{{ route('empresas.edit', $empresa->id_empresa) }}"
                                                class="btn btn-success rounded-circle btn-circle text-white btn-editar-empresa"
                                                title="Editar Empresa">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_campos_personas --}}
            </div> {{-- FIN div_crear_empresa --}}
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
            // INICIO DataTable Lista Personas
            $("#tbl_empresas").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                stripe: true,
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
                scrollX: true,
                ordering: false
            });
            // CIERRE DataTable Lista Personas

        }); // FIN document.ready
    </script>
@stop
