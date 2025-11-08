@extends('layouts.app')

@section('css')
    
@stop

@section('scripts')
    <script src="{{ asset('sweetalert11.22.2/sweetalert2@11.js') }}"></script>

    <script>
        // Oculta header y footer antes de mostrar el Swal
        const header = document.getElementById('header');
        const footer = document.getElementById('footer');

        if (header && footer) {
            header.style.transition = 'opacity 0.3s';
            footer.style.transition = 'opacity 0.3s';
            header.style.opacity = 0;
            footer.style.opacity = 0;

            setTimeout(() => {
                header.classList.add('d-none');
                footer.classList.add('d-none');
            }, 300);
        }

        Swal.fire({
            icon: 'success',
            title: 'Bien',
            text: 'Clave cambiada. Por seguridad, será desconectado y debe volver a iniciar sesión.',
            showConfirmButton: false,
            timer: 3000
        });

        setTimeout(function () {
            window.location.href = "{{ route('logout') }}";
        }, 4000);
    </script>
@endsection
