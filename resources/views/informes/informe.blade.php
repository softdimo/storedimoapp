@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('title', $informe ? $informe->informe_descripcion : 'Informe')
@section('content')

<div class="d-flex p-0">
    <div class="p-0" style="width: 20%">
        @include('layouts.sidebarmenu')
    </div>

    <div class="p-3 d-flex flex-column" style="width: 80%">

        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">{{ $informe ? $informe->informe_descripcion : 'Informe' }}</h3>
            </div>
        </div>

        <div class="row">
           
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" class="floating-labels m-t-20" method="POST" id="informe" >
                            @csrf
                            <div class="row m-l-20 m-r-20">
                                {{-- @foreach($campos['inputs'] as $campo) --}}
                                @foreach($campos->inputs as $campo)
                                    {!! $campo !!}
                                @endforeach
                            </div>
                            <hr>
                            <div class="row m-l-20 m-r-20">
                                {{-- @foreach($campos['checks'] as $campo) --}}
                                @foreach($campos->checks as $campo)
                                    {!! $campo !!}
                                @endforeach
                            </div>
                            <br>
                             <!-- Contenedor para el GIF -->
                            <div id="loadingIndicatorInforme"
                                class="loadingIndicator">
                                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                            </div>
                            <br>
                            <div class="card-footer">
                                <!-- <input type="hidden" name="empresa_id" id="empresa_id"> -->
                                <button type="submit" name="buscar" class="btn btn-submit btn-success" type="button" id="buscar">Buscar</button>
                                <button name="reset" class="btn btn-submit btn-danger" type="reset" id="reset" onclick="limpiar();">Limpiar</button>
                                <p class="float-right mt-2">
                                    Seleccione todos los campos que requiere su informe,
                                    mientras más campos ignore o seleccione como "Todos" tardará más tiempo en obtener los resultados.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card ocultar" id="card">
                    <div class="card-body">
                        <div id="resultado" class="table-responsive">

                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_usuario" id="id_usuario" class="form-control" value="{{session('id_usuario')}}">
                <input type="hidden" name="usuario" id="usuario" class="form-control" value="{{session('usuario')}}">
                <input type="hidden" name="id_rol" id="id_rol" class="form-control" value="{{session('id_rol')}}">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>
<script>

    url = '{{route('respuesta')}}';

    $(document).ready(function()
    {
        $('#informe').validate({
    
            submitHandler: function(form)
            {
                var submitButtonName =  $(this.submitButton).attr("name");
                datos = $(form).serializeArray();

                const loadingIndicator = $("#loadingIndicatorInforme"); // Busca el GIF del form actual

                // Dessactivar Botones
                $("#buscar").prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                $("#reset").prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();

                if(submitButtonName === "buscar")
                {
                    datos = $(form).serializeArray();

                    $.post(url, datos, function(data)
                    {
                        if (data.status)
                        {
                             // Dessactivar Botones
                            $("#buscar").prop("disabled", false).html("Buscar");
                            $("#reset").prop("disabled", false);

                            // Ocultar Spinner
                            loadingIndicator.hide();

                            $('#card').removeClass('ocultar');
                            $('#resultado').empty().append(data.data);

                            $('#tabla').DataTable({
                                dom: 'Blfrtip',
                                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                                "infoEmpty": "No hay registros",
                                "buttons": [
                                {
                                    extend: 'copyHtml5',
                                    text: 'Copiar',
                                    className: 'btn btn-sm btn-warning',
                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button')
                                    }
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: 'Excel',
                                    className: 'btn btn-sm btn-success',
                                    init: function(api, node, config) {
                                        $(node).removeClass('dt-button')
                                    }
                                }
                                ],
                                "lengthMenu": [[10,25,50,100, -1], [10,25,50,100, 'TODOS']],
                            });
                        }
                        else
                        {
                            if (data.status == false)
                            {
                                $("#buscar").prop("disabled", false).html("Buscar");
                                $("#reset").prop("disabled", false);

                                // Ocultar Spinner
                                loadingIndicator.hide();

                                return swal({
                                    type: 'error',
                                    title: 'Error!',
                                    text: 'Debes seleccionar al menos una opción',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        }
                    });
                }
            }
        });

    });

    function limpiar()
    {
        $('#informe').trigger("reset");
        $('#card').addClass('ocultar');
        $('#resultado').empty();
    }

    function mensaje(tipo, mensaje)
    {
        swal({
            type: tipo,
            title: 'Atención!',
            text: mensaje,
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>
@endsection