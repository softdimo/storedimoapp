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
        ->where('menu.estado', 1)
        ->select('menu.*')
        ->distinct()
        ->orderBy('menu.id_menu')
        ->get();

    $menuGroups = $menus->where('ruta', '#')->values();
    $menuItems = $menus->where('ruta', '!=', '#');
@endphp

<aside class="sidebar-modern vh-100" id="sidebar">

    <nav class="sidebar-nav">
        <ul class="nav flex-column" id="sidebarnav">

            <li class="sidebar-section-title">General</li>

            <li class="nav-item">
                <a href="/home" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa fa-th-large sidebar-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @foreach($menuGroups as $menuGroup)
                @php
                    $children = $menuItems->where('menu_id', $menuGroup->id_menu);
                    $hasChildren = $children->count() > 0;
                    $groupIsActive = $children->contains(function($item) {
                        return request()->routeIs($item->ruta);
                    });
                @endphp

                @if($hasChildren)
                    <li class="sidebar-group {{ $groupIsActive ? 'open' : '' }}">
                        <div class="sidebar-group-title"
                             role="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#ul_menu_{{ $menuGroup->id_menu }}"
                             aria-expanded="{{ $groupIsActive ? 'true' : 'false' }}">
                            <span class="sidebar-group-title-text">
                                <i class="fa {{ $menuGroup->icono ?? 'fa-folder-o' }} sidebar-group-icon"></i>
                                {{ $menuGroup->nombre }}
                            </span>
                            <i class="fa fa-chevron-right sidebar-chevron"></i>
                        </div>

                        <ul class="nav flex-column collapse {{ $groupIsActive ? 'show' : '' }}" id="ul_menu_{{ $menuGroup->id_menu }}">
                            @foreach($children as $item)
                                <li class="nav-item">
                                    <a class="sidebar-link sidebar-sublink {{ request()->routeIs($item->ruta) ? 'active' : '' }}"
                                       href="{{ route($item->ruta) }}">
                                        <span>{{ $item->nombre }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach

        </ul>
    </nav>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<script>
    document.addEventListener('DOMContentLoaded', function ()
    {
        document.querySelectorAll('.sidebar-group-title').forEach(function (toggle)
        {
            const targetId = toggle.getAttribute('data-bs-target');
            const targetEl = document.querySelector(targetId);
            const groupLi = toggle.closest('.sidebar-group');

            targetEl.addEventListener('show.bs.collapse', function () {
                groupLi.classList.add('open');
            });

            targetEl.addEventListener('hide.bs.collapse', function () {
                groupLi.classList.remove('open');
            });
        });

        // ===== Responsive: abrir/cerrar sidebar en móvil =====
        const sidebarEl = document.getElementById('sidebar');
        const backdropEl = document.getElementById('sidebarBackdrop');
        const toggleBtn = document.getElementById('sidebarToggle');

        function abrirSidebar() {
            sidebarEl.classList.add('active');
            backdropEl.classList.add('active');
        }

        function cerrarSidebar() {
            sidebarEl.classList.remove('active');
            backdropEl.classList.remove('active');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (sidebarEl.classList.contains('active')) {
                    cerrarSidebar();
                } else {
                    abrirSidebar();
                }
            });
        }

        backdropEl.addEventListener('click', cerrarSidebar);

        // Cierra el sidebar al elegir una opción (solo en móvil)
        sidebarEl.querySelectorAll('.sidebar-link, .sidebar-sublink').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    cerrarSidebar();
                }
            });
        });

        // Si el usuario agranda la ventana, aseguramos que quede cerrado/reseteado
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                cerrarSidebar();
            }
        });
    });
</script>