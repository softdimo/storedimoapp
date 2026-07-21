<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; }
            .container-fluid { min-width: 95%; margin: 0 auto; padding: 15px; }
            .header { background-color: #28a745; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .header h1 { color: white; margin: 0; font-size: 20px; }
            .body { background-color: #f9f9f9; padding: 15x; border: 1px solid #ddd; }
            .footer { background-color: #eee; padding: 15px; text-align: center; font-size: 12px; color: #888; border-radius: 0 0 8px 8px; }
            .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            .info-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
            .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="header">
                <h1>✅ ¡Bienvenido a Storedimo!</h1>
            </div>
            <div class="body">
                <p>Hola, <strong>{{ $empresa->nombre_empresa }}</strong></p>
                <p>Tu registro TRIAL de 15 días ha sido <span class="badge">✓ Aprobado</span> exitosamente. En breve habilitaremos tu acceso a la suite Storedimo.</p>

                <table class="info-table">
                    <tr><td>Empresa:</td><td>{{ $empresa->nombre_empresa }}</td></tr>
                    {{-- <tr><td>NIT:</td><td>{{ $empresa->nit_empresa }}</td></tr> --}}
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
                    Pronto recibirás otro correo con tus credenciales de acceso. Si tienes alguna duda, contáctanos respondiendo este correo.
                </p>
            </div>
            <div class="footer">
                © {{ date('Y') }} Storedimo — Panel Administrativo
            </div>
        </div>
    </body>
</html>
