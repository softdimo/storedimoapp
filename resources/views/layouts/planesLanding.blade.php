<div class="container-fluid px-0">
    <div class="row g-2 m-0"> {{-- m-0 elimina márgenes negativos de la fila; g-2 reduce espacio entre cards --}}
        @foreach ($planesData as $plan)
            {{-- col-md-3 garantiza que entren 4 cards por fila (12 / 3 = 4) --}}
            <div class="col-12 col-sm-6 col-md-3 p-2">
                <div class="card h-100 shadow-sm border-1">
                    {{-- <img src="{{ asset('img/logo.png') }}" class="card-img-top" alt="..."> --}}
                    
                    <div class="card-body d-flex flex-column text-center p-3">
                        <h5 class="card-title fw-bold">{{ $plan['nombre_plan'] }}</h5>
                        <p class="card-text text-muted small">
                            {{ $plan['descripcion_plan'] }}
                        </p>
                        
                        <div class="mt-auto">
                            <h6 class="btn btn-info d-block text-white mb-2 py-2" style="cursor: default; pointer-events: none;">
                                $ {{ $plan['valor_mensual'] }}
                            </h6>
                            <a href="#" class="btn btn-primary w-100 py-2">Obtener</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
