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
            <div class="mt-3 mb-4 col-12 d-flex justify-content-around pe-0 mt-0">
                <div class="col-12 col-md-3 me-2">
                    <div class="form-group d-flex flex-column">
                        <label for="id_tipo_metrica" class="form-label">Tipo Métrica <span class="text-danger">*</span></label>
                        {!! Form::select('id_tipo_metrica', collect(['' => 'Seleccionar...'])->union($tiposMetrica), null,
                            ['class' => 'form-select', 'id' => 'id_tipo_metrica', 'required' => true]) !!}
                    </div>
                </div>

                {{-- ======================================================================= --}}

                <div class="col-12 col-md-6 d-flex justify-content-between" id="div_fechas_metrica">
                    <div class="col-12 col-md-6 me-2">
                        <div class="form-group d-flex flex-column">
                            <label for="fecha_inicial_metrica" class="form-label">
                                Fecha y Hora Inicial<span class="text-danger">*</span>
                            </label>
                            {!! Form::input('datetime-local', 'fecha_inicial_metrica', null, [
                                'class' => 'form-control',
                                'id' => 'fecha_inicial_metrica',
                                'required' => 'required',
                                'onkeydown' => 'return false'
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group d-flex flex-column">
                            <label for="fecha_final_metrica" class="form-label">
                                Fecha y Hora Final<span class="text-danger">*</span>
                            </label>
                            {!! Form::input('datetime-local', 'fecha_final_metrica', null, [
                                'class' => 'form-control',
                                'id' => 'fecha_final_metrica',
                                'required' => 'required',
                                'onkeydown' => 'return false'
                            ]) !!}
                        </div>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                {{-- <div class="mt-4 mb-0 d-flex justify-content-center" id="div_btn_metrica"> --}}
                    <button type="button" class="btn btn-info" id="btn_metrica_ajax">
                        <i class="fa fa-floppy-o text-warning"></i> Consultar
                    </button>
                {{-- </div> --}}

                <button type="button" class="btn btn-warning" id="btn_limpiar_metrica">
                    <i class="fa fa-eraser"></i> Limpiar
                </button>
            </div> {{-- FIN consulta métricas --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}


            <!-- Contenedor para el GIF -->
            <div id="loadingIndicatorMetrica" class="loadingIndicator mb-3">
                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
            </div>

            <div class="table-responsive">
                <table id="tbl_metricas_query" class="table table-bordered table-striped table-hover nowrap" style="width:100%" aria-describedby="métricas personalizadas">
                    <thead id="thead_metricas" class="table-success"></thead>

                    <tbody id="tbody_metricas"></tbody>
                </table>
            </div>

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
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Métricas
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
                "pageLength": 10,
                "scrollX": true,
            });
            // CIERRE DataTable Lista Métricas

            // ===========================================================================================

            // Este bloque va dentro del $(document).ready
            $('#btn_metrica_ajax').click(function(e) {
                let idTipoMetrica = $('#id_tipo_metrica').val();
                let fechaInicial  = $('#fecha_inicial_metrica').val();
                let fechaFinal    = $('#fecha_final_metrica').val();

                if (!idTipoMetrica) {
                    Swal.fire('Atención', 'Por favor, seleccione un tipo de métrica.', 'warning');
                    return;
                }

                if (idTipoMetrica == 9) {
                    // Confirmación con SweetAlert
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "Se borrarán los registros mayores a 30 días. ¡Esta acción no se puede deshacer!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, borrar registros',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            ejecutarBorradoRegistros(rutasMetricas[idTipoMetrica]);
                        }
                    });
                } else {
                    // Validación de fechas para opciones 1-8
                    if (fechaInicial && fechaFinal) {
                        ejecutarConsultaMetrica(rutasMetricas[idTipoMetrica], fechaInicial, fechaFinal);
                    } else {
                        Swal.fire('Campos incompletos', 'Para esta métrica debe seleccionar ambas fechas.', 'info');
                    }
                }
            });

            // ===========================================================================================

            // $('#btn_metrica').attr('readonly');

            // 1. Mapa de rutas según el ID de métrica
            const rutasMetricas = {
                '1': "{{ route('query_total_absoluto') }}",
                '2': "{{ route('query_subtotal_actividad') }}",
                '3': "{{ route('query_movimiento_bd') }}",
                '4': "{{ route('query_por_fuente') }}",
                '5': "{{ route('query_ranking_tenants') }}",
                '6': "{{ route('query_monitoreo_errores') }}",
                '7': "{{ route('query_rutas_utilizadas') }}",
                '8': "{{ route('query_actividad_horas') }}",
                '9': "{{ route('borrar_registros') }}"
            };

            // ==============================================

            // 2. Detectar los cambios del tipo de métrica a consultar
            $('#id_tipo_metrica').change(function() {
                let idTipoMetrica = $(this).val();
                
                if (idTipoMetrica >= 1 && idTipoMetrica <= 8) {
                    $('#div_fechas_metrica').removeClass('d-none').addClass('d-flex');
                    $('#fecha_inicial_metrica, #fecha_final_metrica').attr('required', 'required');
                } else {
                    // Para la opción 9 o cualquier otra, ocultamos fechas
                    $('#div_fechas_metrica').addClass('d-none').removeClass('d-flex');
                    $('#fecha_inicial_metrica, #fecha_final_metrica').removeAttr('required').val('');
                }
            });

            // ==============================================

            // 3. Función AJAX CON fechas
            function ejecutarConsultaMetrica(urlDestino, fechaInicialMetrica, fechaFinalMetrica) {
                // Guardamos la referencia al botón y su contenido original
                let btn = $('#btn_metrica_ajax');
                let originalContent = btn.html();

                $.ajax({
                    url: urlDestino,
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'fecha_inicial_metrica': fechaInicialMetrica,
                        'fecha_final_metrica': fechaFinalMetrica
                    },
                    beforeSend: function() {
                        $('#loadingIndicatorMetrica').show(); // Tu GIF actual
                        
                        // --- NUEVO: Bloqueo del botón ---
                        btn.prop('disabled', true); // Evita más clics
                        btn.html('<i class="fa fa-spinner fa-spin"></i> Consultando...'); // Efecto visual
                    },
                    success: function(respuesta) {
                        let idTipoMetrica = $('#id_tipo_metrica').val();
                        actualizarTablaMetricas(respuesta, idTipoMetrica);
                    },
                    error: function(jqXHR) {
                        console.error("Error en petición", jqXHR.responseJSON);
                        alert("Ocurrió un error al consultar los datos.");
                    },
                    complete: function() {
                        $('#loadingIndicatorMetrica').hide();
                        
                        // --- NUEVO: Restauración del botón ---
                        btn.prop('disabled', false); // Lo habilitamos de nuevo
                        btn.html(originalContent); // Volvemos al icono y texto original
                    }
                });
            }

            // ==============================================

            function actualizarTablaMetricas(respuesta, id) {
                // 1. Destruir la instancia existente si ya es un DataTable
                // if ($.fn.DataTable.isDataTable('#tbl_metricas_query')) {
                //     $('#tbl_metricas_query').DataTable().destroy();
                // }

                let thead = $('#thead_metricas'); // Asegúrate de tener estos IDs en tu HTML
                let tbody = $('#tbody_metricas');
                
                // Limpiamos la tabla antes de empezar
                thead.empty();
                tbody.empty();

                if (!respuesta || (Array.isArray(respuesta) && respuesta.length === 0)) {
                    tbody.append('<tr><td colspan="10" class="text-center">No se encontraron resultados</td></tr>');
                    return;
                }

                let htmlHead = "<tr>";
                let htmlBody = "";

                switch (id) {
                    case '1': // Total Absoluto (Objeto único)
                        htmlHead += "<th>Gran Total Peticiones</th><th>Empresas Conectadas</th>";
                        htmlBody += `<tr>
                            <td>${respuesta.gran_total_peticiones}</td>
                            <td>${respuesta.empresas_conectadas}</td>
                        </tr>`;
                        break;

                    case '2': // Subtotal Actividad
                        htmlHead += "<th>Fuente</th><th>Total Peticiones</th><th>Tenants Activos</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.source}</td>
                                <td>${item.total_peticiones}</td>
                                <td>${item.tenants_activos}</td>
                            </tr>`;
                        });
                        break;

                    case '3': // Movimiento BD
                        htmlHead += "<th>Base de Datos (Tenant)</th><th>Peticiones</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.tenant_db}</td>
                                <td>${item.peticiones_hoy}</td>
                            </tr>`;
                        });
                        break;

                    case '4': // Tráfico por Fuente
                        htmlHead += "<th>Fuente</th><th>Total Peticiones</th><th>Porcentaje</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.source}</td>
                                <td>${item.total_peticiones}</td>
                                <td>${item.porcentaje}%</td>
                            </tr>`;
                        });
                        break;

                    case '5': // Ranking Tenants
                        htmlHead += "<th>Tenant DB</th><th>Fuente</th><th>Peticiones</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.tenant_db}</td>
                                <td>${item.source}</td>
                                <td>${item.peticiones}</td>
                            </tr>`;
                        });
                        break;

                    case '6': // Monitoreo Errores
                        htmlHead += "<th>Fuente</th><th>Ruta (Path)</th><th>Estado</th><th>Ocurrencias</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.source}</td>
                                <td>${item.path}</td>
                                <td><span class="badge bg-danger">${item.status_code}</span></td>
                                <td>${item.ocurrencias}</td>
                            </tr>`;
                        });
                        break;

                    case '7': // Rutas Utilizadas
                        htmlHead += "<th>Ruta (Path)</th><th>Método</th><th>Visitas</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.path}</td>
                                <td>${item.method}</td>
                                <td>${item.visitas}</td>
                            </tr>`;
                        });
                        break;

                    case '8': // Actividad Horas
                        htmlHead += "<th>Hora del Día</th><th>Total Peticiones</th>";
                        respuesta.forEach(item => {
                            htmlBody += `<tr>
                                <td>${item.hora}:00</td>
                                <td>${item.total_peticiones}</td>
                            </tr>`;
                        });
                        break;
                }

                htmlHead += "</tr>";
                thead.append(htmlHead);
                tbody.append(htmlBody);

                // 2. Volver a inicializar DESPUÉS de haber insertado el nuevo HTML
                // $("#tbl_metricas_query").DataTable({
                //     dom: 'Blfrtip',
                //     "infoEmpty": "No hay registros",
                //     stripe: true,
                //     language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
                //     bSort: true,
                //     buttons: [
                //         {
                //             extend: 'excelHtml5',
                //             text: 'Excel',
                //             className: 'btn btn-sm btn-success mr-3',
                //             customize: function(xlsx) {
                //                 var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //                 $('row:first c', sheet).attr('s', '42');
                //             }
                //         }
                //     ],
                //     "pageLength": 10,
                //     "scrollX": true,
                //     "destroy": true // Permite reinicializar sin errores
                // });
            }

            // ==============================================

            // 4. Función AJAX SIN fechas para el borrador de registros superiores a 30 días
            function ejecutarBorradoRegistros(urlDestino) {
                let btn = $('#btn_metrica_ajax');
                let originalContent = btn.html();

                $.ajax({
                    url: urlDestino,
                    type: 'POST',
                    data: { '_token': "{{ csrf_token() }}" },
                    beforeSend: function() {
                        $('#loadingIndicatorMetrica').show();
                        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Borrando...');
                    },
                    success: function(respuesta) {
                        Swal.fire('¡Eliminado!', 'Los registros han sido borrados con éxito.', 'success');
                        $('#id_tipo_metrica').val('').trigger('change'); // Limpiamos el select
                        $('#tbody_metricas, #thead_metricas').empty(); // Limpiamos tabla
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo completar la operación de borrado.', 'error');
                    },
                    complete: function() {
                        $('#loadingIndicatorMetrica').hide();
                        btn.prop('disabled', false).html(originalContent);
                    }
                });
            }

            $('#btn_limpiar_metrica').click(function() {
                // Limpiar select e inputs
                $('#id_tipo_metrica').val('').trigger('change');
                $('#fecha_inicial_metrica, #fecha_final_metrica').val('');
                
                // Limpiar tabla
                if ($.fn.DataTable.isDataTable('#tbl_metricas_query')) {
                    $('#tbl_metricas_query').DataTable().clear().destroy();
                }
                $('#thead_metricas, #tbody_metricas').empty();

                // Notificación opcional
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Filtros limpiados',
                    showConfirmButton: false,
                    timer: 2000
                });
            });

            // ===========================================================================================
            // ===========================================================================================

            

            
        }); // FIN document.ready
    </script>
@stop
