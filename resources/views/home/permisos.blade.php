@extends('layouts.app')
@section('title', 'Permisos')

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
@stop

@section('content')
    <div class="d-flex p-0">
        <div class="p-0" style="width: 20%">
            @include('layouts.sidebarmenu')
        </div>

        <div class="p-1 d-flex flex-column" style="width: 80%">
            {{-- <div class="text-end">
                <a class="nav-link text-blue" href="">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="true" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div> --}}
            <h2 class="text-uppercase text-center" style="color: #337AB7">Actualizar Permisos</h2>

            {!! Form::open(['method' => 'POST', 'route' => ['permisos.store'],
                'class' => 'mt-2', 'autocomplete' => 'off', 'id' => 'formAsignarPermisos']) !!}
            @csrf
        
            @include('permisos.fields')

        {!! Form::close() !!}
        </div>
    </div>
@stop
@section('scripts')
<script>

    // Variable que se comparte desde el trait
    let permisosAsignados = @json($permisosAsignados);
    const permisos = @json($permisos);

        $("#formAsignarPermisos").on("submit", function (e)
     {
            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const cancelButton = form.find('button[type="button"]');
            const loadingIndicator = form.find("div[id^='loadingIndicatorStore']"); // Busca el GIF del form actual
    
            // Dessactivar Botones
            cancelButton.prop("disabled", true);
            submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
            
            // Mostrar Spinner
            loadingIndicator.show();
    });

    document.getElementById('seleccionar_todos').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.permiso-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    $("#id_usuario").change(function()
    {
        let idUsuario = $("#id_usuario").val();
        $('.permiso-checkbox').prop('checked', false);
        const submitButton = $("#bt-guardar-permisos");
        const cancelButton = $("#bt-cancel-permisos");

        $.ajax({
            url: "{{route('traer_permisos_usuario')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {
                '_token': "{{ csrf_token() }}",
                'usuarioId': idUsuario
            },
            beforeSend: function()
            {
                $("#loadingPermissions").show('slow');
                $("#loadingPermissions").removeClass('ocultar');
               
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);
            },
            success: function(response)
            {
                $("#loadingPermissions").hide('slow');
                $("#loadingPermissions").addClass('ocultar');
                submitButton.prop("disabled", false).html("Guardar");
                cancelButton.prop("disabled", false);

                if(response == "error_exception")
                {
                    Swal.fire('Error!', 'Ha ocurrido un error consultando los permisos', 'error');
                    return;
                }

               // Si tiene permisos asignados, marcarlos
                if (response.resultado.length > 0)
                {
                    let permisosAsignados = response.resultado.map(item => item.permission_id);

                    permisosAsignados.forEach(id =>
                    {
                        $('#permiso_' + id).prop('checked', true);
                    });
                }
            }
        });
        
    });
</script>
@stop


