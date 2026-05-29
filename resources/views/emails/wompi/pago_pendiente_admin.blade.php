<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; padding: 30px; }
            /* Cambiado a un tono naranja/amarillo de advertencia para diferenciarlo de "Aprobado" */
            .header { background-color: #fd7e14; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .header h1 { color: white; margin: 0; font-size: 20px; }
            .body { background-color: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
            .footer { background-color: #eee; padding: 15px; text-align: center; font-size: 12px; color: #888; border-radius: 0 0 8px 8px; }
            .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            .info-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
            .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>⏳ Pago en estado "Pendiente por aprobación" — Storedimo</h1>
            </div>
            <div class="body">
                <p>Se ha registrado una nueva suscripción con pago pendiente de verificación (PSE o tarjeta bajo validación).</p>

                <table class="info-table">
                    <tr><td>Empresa:</td><td>{{ $empresa->nombre_empresa }}</td></tr>
                    <tr>
                        <td>{{ $empresa->nit_empresa ? 'NIT:' : 'Documento:' }}</td>
                        <td>{{ $empresa->nit_empresa ?: $empresa->ident_empresa_natural }}</td>
                    </tr>
                    <tr><td>Correo cliente:</td><td>{{ $empresa->email_empresa }}</td></tr>
                    <tr><td>Celular:</td><td>{{ $empresa->celular_empresa }}</td></tr>
                    <tr><td>Dirección:</td><td>{{ $empresa->direccion_empresa }}</td></tr>
                    <tr><td>Plan:</td><td>{{ $suscripcion->nombre_plan }}</td></tr>
                    <tr><td>Modalidad:</td><td>{{ $suscripcion->modalidad_suscripcion }}</td></tr>
                    <tr><td>Valor:</td><td>${{ number_format($suscripcion->valor_suscripcion, 0, ',', '.') }} COP</td></tr>
                    <tr><td>Vigencia:</td><td>{{ $suscripcion->fecha_inicial }} al {{ $suscripcion->fecha_final }}</td></tr>
                    <tr><td>ID Suscripción:</td><td>{{ $suscripcion->id_suscripcion }}</td></tr>
                    <tr><td>ID Transacción Wompi:</td><td>{{ $idTransaccion }}</td></tr>
                    <tr><td>Fecha:</td><td>{{ now()->format('d/m/Y H:i:s') }}</td></tr>
                </table>

                <p style="margin-top: 20px; font-size: 13px; color: #666;">
                    El webhook procesará de forma automática el cambio de estado cuando la red bancaria apruebe la transacción (ID de Estado 15 actual).
                </p>
            </div>
            <div class="footer">
                © {{ date('Y') }} Storedimo — Panel Administrativo
            </div>
        </div>
    </body>
</html>
