<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; }
            .container-fluid { min-width: 95%; margin: 0 auto; padding: 15px; }
            .header { background-color: #dc3545; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .header h1 { color: white; margin: 0; font-size: 20px; }
            .body { background-color: #f9f9f9; padding: 15px; border: 1px solid #ddd; }
            .footer { background-color: #eee; padding: 15px; text-align: center; font-size: 12px; color: #888; border-radius: 0 0 8px 8px; }
            .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .info-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
            .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
            .btn { display: inline-block; background-color: #337AB7; color: white; padding: 12px 28px; border-radius: 6px; text-decoration: none; margin-top: 20px; font-size: 14px; }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="header">
                <h1>⚠️ Tu pago no fue procesado</h1>
            </div>
            <div class="body">
                <p>Hola, <strong>{{ $empresa->nombre_empresa }}</strong></p>
                <p>Lamentablemente tu pago no pudo ser procesado. Esto puede deberse a fondos insuficientes, datos incorrectos o una restricción de tu entidad bancaria.</p>

                <table class="info-table">
                    <tr><td>Empresa:</td><td>{{ $empresa->nombre_empresa }}</td></tr>
                    {{-- <tr><td>NIT:</td><td>{{ $empresa->nit_empresa }}</td></tr> --}}
                    <tr>
                        <td>{{ $empresa->nit_empresa ? 'NIT:' : 'Documento:' }}</td>
                        <td>{{ $empresa->nit_empresa ?: $empresa->ident_empresa_natural }}</td>
                    </tr>
                    <tr><td>Plan:</td><td>{{ $suscripcion->nombre_plan }}</td></tr>
                    <tr><td>Valor:</td><td>${{ number_format($suscripcion->valor_suscripcion, 0, ',', '.') }} COP</td></tr>
                    <tr><td>ID Transacción:</td><td>{{ $idTransaccion }}</td></tr>
                </table>

                <p style="margin-top: 20px;">Puedes reintentar el pago ingresando nuevamente tu NIT en nuestro formulario de registro:</p>

                <a href="{{ config('app.url') }}/home" class="btn">Reintentar pago</a>

                <p style="margin-top: 25px; font-size: 13px; color: #666;">
                    Si el problema persiste, contáctanos respondiendo este correo.
                </p>
            </div>
            <div class="footer">
                © {{ date('Y') }} Storedimo — Desarrollado por ®Softdimo
            </div>
        </div>
    </body>
</html>
