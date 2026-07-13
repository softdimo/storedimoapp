<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title>Registro Usuario</title>
    </head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; padding: 30px; }
            .header { background-color: #28a745; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .header h1 { color: white; margin: 0; font-size: 20px; }
            .body { background-color: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
            .footer { background-color: #eee; padding: 15px; text-align: center; font-size: 12px; color: #888; border-radius: 0 0 8px 8px; }
            .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            .info-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
            .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        </style>
    <body>
         <body>
        <div class="container">
            <div class="header">
                <h1>✅ Nuevo Registro de Usuario Administrador</h1>
            </div>
            <div class="body">
                <p>Hola,</p>
                <p>Se ha realizado el registro de un usuario Administrador para su empresa.</p>
                <p>Por favor, ingrese al listado de usuarios y verifique la información.</p>
                <p>
                    Recuerda solicitar los accesos necesarios para el uso del sistema.
                </p>
            </div>
            <br>
            <div class="footer">
                <p>Este mensaje es automático, por favor no responder</p>
                <p>Gracias.</p>
                <p><b>© {{ date('Y') }} Storedimo — Panel Administrativo</b></p>
            </div>
        </div>
    </body>
</html>
