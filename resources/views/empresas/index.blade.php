@extends('layouts.app')
@section('title', 'Empresas')

@section('css')
    <style>

    </style>
@stop

@section('content')
    @php
        use Illuminate\Support\Facades\Crypt;
    @endphp

    <div id="modal-overlay"></div>
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between align-items-center pe-3 mt-3 mb-3">
                <div>
                    @if($rolId == 3)
                        <a href="{{ route('empresas.create') }}" class="btn-modern-primary">
                            <i class="fa fa-plus-circle"></i> Crear Empresa
                        </a>
                    @else
                        <p>&nbsp;</p>
                    @endif
                </div>
                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="help-icon-modern" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarEmpresas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"></i>
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

            <div class="card-modern">
                <div class="card-modern-header">
                    <i class="fa fa-building"></i>
                    <span>Listar Empresas</span>
                </div>

                <div class="col-12 p-3" id="">
                    <div class="{{-- table-responsive --}}">
                        <table class="table table-modern w-100 mb-0" id="tbl_empresas"
                            aria-describedby="empresas">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>Nit Empresa</th>
                                    <th>Documento Persona Natural</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                    <th>Dirección</th>

                                    @if($rolId == 3)
                                        <th>DB CONNECTION</th>
                                        <th>DB HOST</th>
                                        <th>DB DATABASE</th>
                                        <th>DB USERNAME</th>
                                        <th>DB PASSWORD</th>
                                    @endif

                                    <th>LOGO</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($empresas as $empresa)
                                    <tr class="text-center align-middle">
                                        <td>{{ $empresa->nit_empresa }}</td>
                                        <td>{{ $empresa->ident_empresa_natural }}</td>
                                        <td>{{ $empresa->nombre_empresa }}</td>
                                        <td>{{ $empresa->telefono_empresa }}</td>
                                        <td>{{ $empresa->celular_empresa }}</td>
                                        <td>{{ $empresa->email_empresa }}</td>
                                        <td>{{ $empresa->direccion_empresa }}</td>

                                        @if($rolId == 3)
                                            <td>{{ $empresa->tipo_bd ? $empresa->tipo_bd : '' }}</td>
                                            <td>{{ $empresa->db_host ? Crypt::decrypt($empresa->db_host) : '' }}</td>
                                            <td>{{ $empresa->db_database ? Crypt::decrypt($empresa->db_database) : '' }}</td>
                                            <td>{{ $empresa->db_username ? Crypt::decrypt($empresa->db_username) : '' }}</td>
                                            <td>{{ $empresa->db_password ? Crypt::decrypt($empresa->db_password) : '' }}</td>
                                        @endif

                                        @if (is_null($empresa->logo_empresa))
                                            <td class="align-middle"></td>
                                        @else
                                            <td class="align-middle">
                                                <img src="{{ $empresa->logo_empresa }}" alt="Empresa"
                                                    style="max-width: 50px;">
                                            </td>
                                        @endif

                                        <td>
                                            @if(strtolower($empresa->estado ?? '') == 'activo')
                                                <span class="badge text-bg-success">{{ $empresa->estado }}</span>
                                            @elseif($empresa->estado)
                                                <span class="badge text-bg-danger">{{ $empresa->estado }}</span>
                                            @endif
                                        </td>

                                        @if($rolId == 3)
                                            <td>
                                                <a href="{{ route('empresas.edit', $empresa->id_empresa) }}"
                                                    class="btn btn-success rounded-circle btn-circle text-white btn-editar-empresa"
                                                    title="Editar Empresa">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <p>&nbsp;</p>
                                            </td>
                                        @endif
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
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-modern-excel mr-3',
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

            $(document).on('select2:open', function(e) {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    setTimeout(function() {
                        searchField.focus();
                    }, 10); // Un pequeño delay ayuda a que el buscador se renderice
                }
            });

        }); // FIN document.ready
    </script>
@stop