<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Navidad Coinco')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>
        /* Esta estructura hace que el footer quede al fondo, incluso si poco contenido */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1; /* Ocupa el espacio disponible */
            padding: 20px;
        }
        /* Opcional: para que footer tenga fondo y se vea separado */
        footer {
            background-color: #005ea6;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
