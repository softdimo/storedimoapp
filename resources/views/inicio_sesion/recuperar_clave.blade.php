@extends('layouts.app')
@section('title', 'Recovery Password')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <form class="border border-dark-subtle p-5 shadow-lg rounded-4 bg-white text-center" method="post" action="{{route('recuperar_clave_email')}}" autocomplete="off">
        @csrf
        <h3 class="mb-4 fw-bold text-primary">Recuperar Clave</h3>

        <div class="mb-4">
            <input class="w-100 form-control p-3" type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="mb-4">
            <input class="w-100 form-control p-3" type="text" name="identificacion" id="identificacion" placeholder="Identificación" required>
        </div>

        <div class="mt-4 d-flex flex-column gap-3">
            <button class="btn btn-primary btn-lg w-100" type="submit">Enviar Correo</button>
            <a class="btn btn-outline-primary btn-lg w-100" href="{{route('login')}}">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al Login
            </a>
        </div>
    </form>
</div>
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#email").trigger('focus');
        });
    </script>
@endsection
