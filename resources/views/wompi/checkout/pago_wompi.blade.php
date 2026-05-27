@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        {{-- Icono visual de seguridad --}}
                        <div class="mb-4">
                            <i class="fas fa-shield-alt text-success fa-3x"></i>
                        </div>

                        <h3 class="card-title mb-3 fw-bold text-dark">Estás a un paso de activar Storedimo</h3>
                        <p class="text-muted mb-4">
                            Hemos registrado los datos de <strong>{{ $nombre }}</strong> con éxito.
                            Para finalizar la activación de tu suite, procesa el pago seguro a continuación.
                        </p>

                        {{-- Caja de resumen de cobro --}}
                        <div class="bg-light p-3 rounded mb-4 border text-start">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-secondary small">Referencia de Pago:</span>
                                <span class="font-monospace fw-bold text-dark small">{{ $referencia }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary fw-bold">Total a Pagar:</span>
                                {{-- Convertimos los centavos a pesos visualmente para el usuario --}}
                                <span class="fs-4 fw-bold text-success">${{ number_format($valor / 100, 0, ',', '.') }} COP</span>
                            </div>
                        </div>

                        {{-- Formulario nativo que Wompi intercepta --}}
                        {{-- <form> --}}
                        @php
                            $wompiUrl = "https://checkout.wompi.co/p/?" . http_build_query([
                                'public-key'              => $publicKey,
                                'currency'                => 'COP',
                                'amount-in-cents'         => $valor,
                                'reference'               => $referencia,
                                'signature:integrity'     => $firma,
                                'customer-data:email'     => $email,
                                'customer-data:full-name' => $nombre,
                                'redirect-url'            => request()->getSchemeAndHttpHost() . '/pago_resultado',
                            ]);
                        @endphp
                        {{-- </form> --}}

                        <a href="{{ $wompiUrl }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-lock me-2"></i> Pagar con Wompi
                        </a>

                        <div class="mt-4 pt-3 border-top text-muted small">
                            <i class="fas fa-lock me-1"></i> Pagos procesados de forma segura por Wompi (Bancolombia)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
