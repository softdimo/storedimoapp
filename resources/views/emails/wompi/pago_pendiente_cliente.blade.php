<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; padding: 30px; }
            /* Cambiado a gris azulado neutro para denotar un estado de transición formal */
            .header { background-color: #607D8B; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .header h1 { color: white; margin: 0; font-size: 22px; }
            .body { background-color: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
            .footer { background-color: #eee; padding: 15px; text-align: center; font-size: 12px; color: #888; border-radius: 0 0 8px 8px; }
            /* Badge cambiado a naranja/ámbar para alertar "En proceso" sin alarmar */
            .badge { background-color: #ff9800; color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; }
            .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .info-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
            .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1>Tu registro en Storedimo está en proceso</h1>
        </div>
        <div class="body">
            <p>Hola, <strong>{{ $empresa->nombre_empresa }}</strong></p>
            <p>Hemos recibido la intención de tu pago y actualmente se encuentra en estado <span class="badge">⏳ Pendiente</span>.</p>
            <p>Estamos esperando la confirmación definitiva de tu entidad bancaria (común en pagos realizados por PSE o tarjetas en validación) para activar formalmente tu suite.</p>

            <table class="info-table">
                <tr><td>Empresa:</td><td>{{ $empresa->nombre_empresa }}</td></tr>
                <tr>
                    <td>{{ $empresa->nit_empresa ? 'NIT:' : 'Documento:' }}</td>
                    <td>{{ $empresa->nit_empresa ?: $empresa->ident_empresa_natural }}</td>
                </tr>
                <tr><td>Correo registrado:</td><td>{{ $empresa->email_empresa }}</td></tr>
                <tr><td>Plan suscrito:</td><td>{{ $suscripcion->nombre_plan }}</td></tr>
                <tr><td>Modalidad:</td><td>{{ $suscripcion->modalidad_suscripcion }}</td></tr>
                <tr><td>Valor en verificación:</td><td>${{ number_format($suscripcion->valor_suscripcion, 0, ',', '.') }} COP</td></tr>
                <tr><td>Vigencia estimada:</td><td>{{ $suscripcion->fecha_inicial }} al {{ $suscripcion->fecha_final }}</td></tr>
                <tr><td>ID Transacción Wompi:</td><td>{{ $idTransaccion }}</td></tr>
            </table>

            <p style="margin-top: 25px; font-size: 13px; color: #666; line-height: 1.5;">
                <strong>¿Qué sigue ahora?</strong><br>
                Tan pronto como el banco libere los fondos, nuestro sistema procesará la activación de forma automática. Recibirás de inmediato un correo electrónico de bienvenida con tus credenciales de acceso definitivas. No necesitas realizar un nuevo intento de pago.
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Storedimo — Desarrollado por ®Softdimo
        </div>
    </div>
    </body>
</html>
