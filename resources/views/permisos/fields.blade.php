<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0"
        style="background-color: #337AB7">Actualización de Permisos (Obligatorios * )</h5>

    <div class="row m-0 p-3" id="div_campos_usuarios">
    
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="usuario_id" class="form-label">Usuario <span class="text-danger">*</span></label>
                {!! Form::select('id_usuario', collect(['' => 'Seleccionar...'])->union($usuarios), null,
                    ['class' => 'form-select select2', 'id' => 'id_usuario', 'required']) !!}
            </div>
        </div>

        <div class="col-12 col-md-2">
            <p>&nbsp;</p>
        </div>

        <div class="col-12 col-md-3">
              <!-- Contenedor para el GIF -->
            <div id="loadingPermissions"
                class="ocultar">
                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando..." height="50" width="50">
                <p><strong>Procesando...</strong></p>
            </div>
        </div>

        <div class="row pb-4 pt-4">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                <h6 class="border rounded text-center pt-2 pb-2 m-0" style="background-color: #EEEEEE;">Listado de Permisos</h6>
            </div>

            <div class="row pt-4">
                <div class="col-xs-12 col-sm-12 col-md6">
                    <p><strong>Por favor, seleccione los permisos que deseas asignar</strong></p>
                </div>
            </div>

            <div class="col-16 col-md-16 pt-2">
            {{-- Checkbox para seleccionar todos --}}
            <div class="permiso-item" style="padding-bottom: 20px;">
                <input type="checkbox" id="seleccionar_todos">
                <label for="seleccionar_todos" class="pointer"><strong>Seleccionar/Quitar todos</strong></label>
            </div>

                <div class="permiso-grid" id="permisos-grid">
                    @foreach ($permisos as $permiso)
                        <div class="permiso-item">
                            <input
                                type="checkbox"
                                class="permiso-checkbox"
                                name="permisos[]"
                                value="{{ $permiso->id }}"
                                id="permiso_{{ $permiso->id }}"
                                {{ in_array($permiso->id, $permisosAsignados ?? []) ? 'checked' : '' }}
                            >
                            <label for="permiso_{{ $permiso->id }}" class="pointer">{{ $permiso->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorStore"
            class="loadingIndicator">
            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="mt-5 mb-2 d-flex justify-content-center">
            <button type="submit" class="btn btn-success rounded-2 me-3" id="bt-guardar-permisos">
                <i class="fa fa-floppy-o"></i>
                Guardar
            </button>
        </div>
    </div>
</div>
