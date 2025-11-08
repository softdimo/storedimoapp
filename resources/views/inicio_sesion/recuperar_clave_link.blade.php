@extends('layouts.app')
@section('title', 'Link Recuperación Clave')

@section('content')
    <div class="d-flex justify-content-center align-items-center bg-light py-4 vh-100">
        <div class="border border-dark-subtle p-4 shadow-lg rounded-4 bg-white text-center" style="overflow-y: auto;">
            <div class="row mb-3">
                <div class="col-12">
                    <h3 class="text-center text-uppercase">Recuperar Clave</h3>
                </div>
            </div>

            {{-- =========================================================== --}}

            <div class="d-flex justify-content-center align-items-center">
                <form class="border border-dark-subtle p-3 rounded-4" method="post" action="{{route('recuperar_clave_update')}}" autocomplete="off" id="formCambiarClaveLink">
                    @csrf

                    <input type="hidden" name="id_usuario" id="id_usuario" value="{{$usuIdRecuperarClave}}">
                    
                    {{-- ============================================ --}}

                    <div class="mb-4">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="w-100 form-control" type="password" name="clave_nueva" id="clave_nueva" placeholder="Nueva clave" required>
                    </div>

                    <div class="mb-5">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="w-100 form-control" type="password" name="clave_nueva_confirmar" id="clave_nueva_confirmar" placeholder="Confirma clave" required>
                    </div>

                    {{-- ============================================ --}}

                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorStore" class="loadingIndicator">
                        <img src="{{asset('imagenes/loading.gif')}}" alt="Procesando...">
                    </div>

                    {{-- ============================================ --}}

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning text-white">Cambiar clave</button>
                    </div>

                    {{-- ============================================ --}}

                    <div class="mt-4 d-flex justify-content-start">
                        <a class="btn btn-primary text-white" href="{{route('login')}}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#clave_nueva").trigger('focus');

            function validatePassword(nuevaClaveValor) {
                let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+\-/_¿¡#.,:;=~^(){}\[\]<>`|"'])[A-Za-z\d@$!%*?&+\-/_¿¡#.,:;=~^(){}\[\]<>`|"']{6,}$/;
                if (!regex.test(nuevaClaveValor)) {
                    return "La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un número, un carácter especial, y ser de al menos 6 caracteres.";
                }
                return null;
            }

            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formCambiarClaveLink']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']"); // Busca el GIF del form actual

                let nuevaClaveValor = $('#clave_nueva').val();
                let confirmarClaveValor = $('#clave_nueva_confirmar').val();

                if (nuevaClaveValor.trim() === '' || confirmarClaveValor.trim() === '') {
                    Swal.fire('Cuidado!', 'Ambos campos de contraseña deben estar diligenciados!', 'warning');
                    return;
                }

                if (nuevaClaveValor !== confirmarClaveValor) {
                    Swal.fire('Error!', 'Las contraseñas no coinciden!', 'error');
                    return;
                }

                // Validación de la seguridad de la contraseña
                let errorMessage = validatePassword(nuevaClaveValor);

                if (errorMessage) {
                    Swal.fire('Error!', errorMessage, 'error');
                    return;
                }

                // Dessactivar Botones
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                
                // Mostrar Spinner
                loadingIndicator.show();

                // Enviar formulario manualmente
                this.submit();
            });
        });
    </script>
@endsection
