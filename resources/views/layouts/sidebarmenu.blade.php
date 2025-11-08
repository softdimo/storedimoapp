@php
    $user_id = session('id_usuario');
    $user_type = 'App\\Models\\Usuario';

    // Aseguramos usar la conexión principal para consultar menús y permisos
    $menus = DB::connection('mysql')->table('menu')
        ->join('permissions', 'menu.permission_id', '=', 'permissions.id')
        ->join('model_has_permissions', function($join) use ($user_id, $user_type)
        {
            $join->on('model_has_permissions.permission_id', '=', 'permissions.id')
                 ->where('model_has_permissions.model_id', '=', $user_id)
                 ->where('model_has_permissions.model_type', '=', $user_type);
        })
        ->where('menu.estado_id', 1)
        ->select('menu.*')
        ->distinct()
        ->orderBy('menu.id_menu')
        ->get();
    
    $menuGroups = $menus->where('ruta', '#')->values();
    $menuItems = $menus->where('ruta', '!=', '#');
@endphp

<aside class="vh-100 sidebar" id="sidebar" style="border: 1px solid #e7e7e7">
    <nav class="w-100 ">
        <ul class="nav navbar-nav d-flex flex-column justify-content-center flex-nowrap" id="sidebarnav">
            <li class="pt-1 pb-1 d-flex justify-content-between align-items-center"
                style="background-color: #EEEEEE; border-bottom: 1px solid #e7e7e7">
                <i class="fa fa-th-list text-center" style="color: #000; width: 10%"></i>
                <a href="/home" class="nav-link active text-decoration-none text-start" style="width: 80%">Menú Principal</a>
                <span class="" style="width: 10%"></span>
            </li>

            @foreach($menuGroups as $menuGroup)
                @php
                    $hasChildren = $menuItems->where('menu_id', $menuGroup->id_menu)->count() > 0;
                @endphp
                @if($hasChildren)
                    <li class="nav-item pt-1 pb-1 d-flex flex-column" style="border-bottom: 1px solid #e7e7e7">
                        <div class="d-flex flex-row justify-content-between align-items-center colapsar"
                             id="menu_{{$menuGroup->id_menu}}"
                             role="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#ul_menu_{{$menuGroup->id_menu}}"
                             aria-controls="ul_menu_{{$menuGroup->id_menu}}"
                             aria-expanded="false"
                             aria-label="Toggle navigation">
                            <div class="col-11">
                                <i class="fa {{$menuGroup->icono}} text-center" style="color: #000; width: 10%"></i>
                                <a href="#" class="text-decoration-none" style="width: 80%" id="">{{$menuGroup->nombre}}</a>
                            </div>
                            <div class="col-1 text-center text-dark">
                                <span class="fa collapse-icon" aria-hidden="false" style=""></span>
                            </div>
                        </div>

                        <ul class="nav collapse navbar-collapse ps-3" id="ul_menu_{{$menuGroup->id_menu}}">
                            @foreach($menuItems->where('menu_id', $menuGroup->id_menu) as $item)
                                <li class="nav-item w-100">
                                    <a class="link-underline-light" href="{{route($item->ruta)}}">{{$item->nombre}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function ()
    {
        const elementosColapsar = document.querySelectorAll('.colapsar');

        elementosColapsar.forEach(colapsar => {
            const iconoColapsar = colapsar.querySelector('.collapse-icon');

            iconoColapsar.classList.add('fa-angle-left');

            colapsar.addEventListener('click', function () {
                iconoColapsar.classList.toggle('fa-angle-left');
                iconoColapsar.classList.toggle('fa-angle-down');
            });
        });
    });
</script>
