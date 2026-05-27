@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-sm border-0 p-5">
                    <div class="card-body">

                        @if($estado === 'APPROVED')
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-3">¡Pago aprobado!</h3>
                            <p class="text-muted mb-4">
                                Hemos recibido tu pago exitosamente. En las próximas horas
                                activaremos tu suite <strong>Storedimo</strong> y te
                                enviaremos un correo de bienvenida con los accesos.
                            </p>

                        @elseif($estado === 'DECLINED' || $estado === 'ERROR' || $estado === 'VOIDED')
                            <div class="mb-4">
                                <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-3 text-danger">Pago no aprobado</h3>
                            <p class="text-muted mb-4">
                                Tu pago no pudo ser procesado. Por favor intenta nuevamente
                                o usa otro método de pago.
                            </p>
                            <a href="{{ url('/home') }}" class="btn btn-warning px-5 mb-3">
                                <i class="fas fa-redo me-2"></i> Intentar nuevamente
                            </a>

                        @else
                            <div class="mb-4">
                                <i class="fas fa-clock text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Pago en proceso</h3>
                            <p class="text-muted mb-4">
                                Tu pago está siendo verificado por tu entidad bancaria.
                                Te notificaremos por correo cuando se confirme.
                            </p>
                        @endif

                        <div class="alert alert-light border small font-monospace mb-4">
                            ID de Operación: {{ $id_transaccion }}
                        </div>

                        <a href="{{ url('/') }}" class="btn btn-outline-primary px-5">
                            Volver al Inicio
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
