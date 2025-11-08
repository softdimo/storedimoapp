
<footer id="footer" class="text-center text-white p-1" style="background-color: #337AB7">
    <div class="row m-0 w-100">
        <div class="flex-center">
            <span class="d-block" style="font-size: 16px">Copyright © {{ date('Y') }} Storedimo</span>
            <span class="" style="font-size: 13px">Desarrollado por ®Softdimo - Todos los derechos reservados</span>
        </div>
    </div>
</footer>

@yield('scripts')

    <!-- Bootstrap Bundle JS 5.3.2 -->
    <script src="{{ asset('bootstrap/bootstrap5.3.2.bundle.min.js') }}"></script>

    <!-- SELECT2 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> --}}
    <script src="{{asset('select2_4.0.13/select2.min.js')}}"></script>
    {{-- <script src="{{asset('vendor/select2-4.1.0/dist/js/select2.min.js')}}"></script> --}}

    {{-- Sweetalert (No necesita jquery para funcionar) --}}
    <script src="{{ asset('js/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>

    <!-- SCRIPTS -->
    @include('sweetalert::alert')
    
    <script>

        $('.select2').select2();

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Cerrar el menú al hacer clic fuera de él en dispositivos móviles
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>
