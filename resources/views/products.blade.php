<!DOCTYPE html>
<html>
<head>
    <title>AgroCapital - Productos</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Catálogo de Productos</h1>
        
        <!-- Filtros -->
        <div class="flex gap-4 mb-6">
            <input type="text" id="search" placeholder="Buscar..." class="p-2 border rounded-lg w-full md:w-1/3">
            <select id="category" class="p-2 border rounded-lg">
                <option value="">Todas las categorías</option>
                <option value="Cereales">Cereales</option>
                <option value="Frutas">Frutas</option>
            </select>
        </div>

        <!-- Listado -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="products-container">
            <!-- JS cargará productos aquí -->
        </div>
    </div>
</body>
</html>