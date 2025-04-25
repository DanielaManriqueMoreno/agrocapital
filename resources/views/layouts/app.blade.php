<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AgroCapital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <header class="bg-green-700 text-white">
        <div class="container mx-auto p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">AgroCapital</h1>
                
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <footer class="bg-green-800 text-white mt-8">
        <div class="container mx-auto p-4">
            <p class="text-center">&copy; {{ date('Y') }}  Todos los derechos reservados</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>