@extends('layouts.app')
@section('title', 'Inicio')

@section('css')
    <style>
        .softdimo-dash { background:#F5F6FA; border-radius:12px; padding:1.5rem; }
        .softdimo-dash .stat-card {
            background:#fff; border:1px solid #ECEDF2; border-radius:16px;
            padding:1.5rem; box-shadow:0 1px 2px rgba(16,24,40,.05);
            height:100%;
        }
        .softdimo-dash .stat-card.stat-primary { background:linear-gradient(135deg,#4F6EF7,#3D5AE0); color:#fff; }
        .softdimo-dash .stat-card.stat-success { background:linear-gradient(135deg,#16A34A,#128a3e); color:#fff; }
        .softdimo-dash .stat-icon { font-size:1.8rem; opacity:.9; }
        .softdimo-dash .stat-value { font-size:2.2rem; font-weight:800; line-height:1.1; }
        .softdimo-dash .stat-label { font-size:.85rem; opacity:.85; }
        .softdimo-dash .stat-sub-label { font-size:.8rem; opacity:.85; }
        .softdimo-dash .stat-sub-value { font-size:1.1rem; font-weight:700; }
        .softdimo-dash .section-card {
            background:#fff; border:1px solid #ECEDF2; border-radius:16px;
            padding:1.25rem; box-shadow:0 1px 2px rgba(16,24,40,.05);
        }
        .softdimo-dash .section-title { font-weight:700; color:#1B1F3B; margin-bottom:.9rem; }
        .softdimo-dash .list-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:.55rem 0; border-bottom:1px solid #F1F2F6; font-size:.9rem;
        }
        .softdimo-dash .list-row:last-child { border-bottom:none; }
        .softdimo-dash .quick-btn { border-radius:10px; padding:.6rem 1.1rem; font-weight:500; }
        .softdimo-dash .empresa-title { color:#1B1F3B; font-weight:800; letter-spacing:.02em; }
    </style>
@stop

@section('content')
<div class="d-flex p-0">
    <div class="p-0 sidebar-container">
        @include('layouts.sidebarmenu')
    </div>

    <div class="p-3 d-flex flex-column content-container">

        @if (isset($alertaTrial))
            <div class="w-100 mt-0 mb-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {!! $alertaTrial !!}
                </div>
            </div>
        @endif

        <div class="softdimo-dash">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="empresa-title mb-0 text-uppercase">{{ $nombreEmpresa }}</h4>
                <span class="text-muted small">{{ now()->translatedFormat('d \d\e F, Y') }}</span>
            </div>

            {{-- Tarjetas de Ventas / Compras (usa tus variables actuales, funcionan sin tocar el controller) --}}
            <div class="row g-3 mb-3">
                <div class="col-12 col-lg-6">
                    <div class="stat-card stat-primary">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-label">Ventas Día</div>
                                <div class="stat-value"><i class="fa fa-usd stat-icon"></i> {{ number_format($ventaDiaMes->ventasDia ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="stat-sub-label">Ventas Mes</div>
                                <div class="stat-sub-value">{{ number_format($ventaDiaMes->ventasMes ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="stat-card stat-success">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-label">Compras Día</div>
                                <div class="stat-value"><i class="fa fa-shopping-cart stat-icon"></i> {{ number_format($entradaDiaMes->entradasDia ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="stat-sub-label">Compras Mes</div>
                                <div class="stat-sub-value">{{ number_format($entradaDiaMes->entradasMes ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actividades + Top productos: opcionales, solo aparecen si el controller las envía --}}
            @if(isset($actividades) || isset($productosMasVendidos))
            <div class="row g-3 mb-3">

                @isset($actividades)
                <div class="col-12 col-lg-6">
                    <div class="section-card">
                        <div class="section-title">Últimas Actividades</div>
                        @forelse($actividades as $a)
                            <div class="list-row">
                                <span><strong>{{ $a->usuario }}</strong> {{ $a->descripcion }}</span>
                                <span class="text-muted">{{ $a->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Sin actividad reciente.</p>
                        @endforelse
                    </div>
                </div>
                @endisset

                @isset($productosMasVendidos)
                <div class="col-12 col-lg-6">
                    <div class="section-card">
                        <div class="section-title">Productos Más Vendidos</div>
                        @forelse($productosMasVendidos as $i => $p)
                            <div class="list-row">
                                <span>{{ $i + 1 }}. {{ $p->nombre ?? ($p->producto->nombre ?? 'Producto') }}</span>
                                <span class="text-muted">{{ $p->unidades }} uds</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Aún no hay ventas registradas este mes.</p>
                        @endforelse
                    </div>
                </div>
                @endisset

            </div>
            @endif

            {{-- Acciones rápidas: opcional, cámbialas por tus rutas reales --}}
            <div class="section-card">
                <div class="section-title">Acciones Rápidas</div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ url('/productos/create') }}" class="btn btn-primary quick-btn">
                        <i class="fa fa-plus"></i> Nuevo Producto
                    </a>
                    <a href="{{ url('/ventas/create') }}" class="btn btn-success quick-btn">
                        <i class="fa fa-cart-plus"></i> Nueva Venta
                    </a>
                    <a href="{{ url('/clientes/create') }}" class="btn quick-btn text-white" style="background:#1B1F3B;">
                        <i class="fa fa-user-plus"></i> Nuevo Cliente
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            // $("#username").trigger('focus');
        });
    </script>
@stop