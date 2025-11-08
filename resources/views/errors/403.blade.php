{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso prohibido</title>
    <style>
        body {
            background-color: #f8fafc;
            color: #1a202c;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            text-align: center;
        }
        h1 {
            font-size: 6rem;
            margin-bottom: 0.5rem;
        }
        p {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        a {
            text-decoration: none;
            color: #3490dc;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>403</h1>
    <p>Acceso prohibido</p>
    <p>No tienes permiso para acceder a esta página o realizar esta acción.</p>
    <a href="{{ url('/home') }}">Volver al inicio</a>
</body>
</html>