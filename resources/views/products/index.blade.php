@extends('layouts.app')
@section('title', 'Listado de Productos Agrícolas')
@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-bold mb-4">Productos Agrícolas</h2>
        
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre:</label>
                    <input type="text" id="search" class="w-full p-2 border rounded" placeholder="Escribe para buscar...">
                </div>
                <div class="w-full md:w-1/2">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por categoría:</label>
                    <select id="category" class="w-full p-2 border rounded">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="product-card bg-white rounded-lg shadow overflow-hidden" 
                     data-name="{{ strtolower($product->name) }}" 
                     data-category="{{ strtolower($product->category) }}">
                    <div class="h-48 bg-gray-200">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <span>Sin imagen</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-2">Categoría: {{ $product->category }}</p>
                        <p class="text-green-600 font-bold mb-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-500 mb-4">Stock: {{ $product->stock }} unidades</p>
                        <button class="view-details bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 w-full"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-description="{{ $product->description }}"
                                data-category="{{ $product->category }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"
                                data-image="{{ $product->image }}">
                            Ver detalles
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal para detalles del producto -->
    <div id="product-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
            <div class="flex justify-between items-start mb-4">
                <h3 id="modal-title" class="text-2xl font-bold"></h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2">
                    <div id="modal-image" class="h-64 bg-gray-200 rounded mb-4"></div>
                </div>
                <div class="w-full md:w-1/2">
                    <p class="text-gray-600 mb-2">Categoría: <span id="modal-category"></span></p>
                    <p class="text-green-600 font-bold text-xl mb-2">$<span id="modal-price"></span></p>
                    <p class="text-gray-500 mb-4">Stock: <span id="modal-stock"></span> unidades</p>
                    <p class="text-gray-700 mb-4"><span id="modal-description"></span></p>
                    
                    <!-- Botones para probar las APIs -->
                    <div class="mt-6 space-y-3">
                        <button id="check-stock-btn" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 w-full">
                            Verificar disponibilidad (API)
                        </button>
                        
                        <div class="flex space-x-2">
                            <input type="number" id="discount-input" min="0" max="100" value="10" class="border rounded p-2 w-1/3" placeholder="% descuento">
                            <button id="calculate-discount-btn" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 flex-1">
                                Calcular descuento (API)
                            </button>
                        </div>
                    </div>
                    
                    <!-- Resultados de las APIs -->
                    <div id="api-results" class="mt-4 p-4 bg-gray-100 rounded hidden">
                        <h4 class="font-semibold mb-2">Resultados de la API:</h4>
                        <div id="results-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtrado por nombre
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('input', filterProducts);
        
        // Filtrado por categoría
        const categorySelect = document.getElementById('category');
        categorySelect.addEventListener('change', filterProducts);
        
        // Función para filtrar productos
        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categorySelect.value.toLowerCase();
            
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productName = card.getAttribute('data-name');
                const productCategory = card.getAttribute('data-category');
                
                const nameMatch = productName.includes(searchTerm);
                const categoryMatch = selectedCategory === '' || productCategory === selectedCategory;
                
                if (nameMatch && categoryMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // Modal de detalles
        const modal = document.getElementById('product-modal');
        const closeModal = document.getElementById('close-modal');
        const viewButtons = document.querySelectorAll('.view-details');
        
        // Variables para las APIs
        let currentProductId = null;
        const checkStockBtn = document.getElementById('check-stock-btn');
        const calculateDiscountBtn = document.getElementById('calculate-discount-btn');
        const discountInput = document.getElementById('discount-input');
        const apiResults = document.getElementById('api-results');
        const resultsContent = document.getElementById('results-content');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const product = this.dataset;
                currentProductId = product.id; // Guardar el ID del producto actual
                
                document.getElementById('modal-title').textContent = product.name;
                document.getElementById('modal-category').textContent = product.category;
                document.getElementById('modal-price').textContent = parseFloat(product.price).toFixed(2);
                document.getElementById('modal-stock').textContent = product.stock;
                document.getElementById('modal-description').textContent = product.description;
                
                const modalImage = document.getElementById('modal-image');
                if (product.image) {
                    modalImage.innerHTML = `<img src="/images/${product.image}" alt="${product.name}" class="w-full h-full object-cover">`;
                } else {
                    modalImage.innerHTML = `<div class="w-full h-full flex items-center justify-center text-gray-500"><span>Sin imagen</span></div>`;
                }
                
                // Ocultar resultados de API anteriores
                apiResults.classList.add('hidden');
                
                modal.classList.remove('hidden');
            });
        });
        
        // Verificar stock (API)
        checkStockBtn.addEventListener('click', async function() {
            try {
                const response = await fetch(`/api/products/${currentProductId}/check-stock`);
                const data = await response.json();
                
                apiResults.classList.remove('hidden');
                
                if (data.success) {
                    resultsContent.innerHTML = `
                        <p><strong>Producto:</strong> ${data.data.product}</p>
                        <p><strong>Cantidad en stock:</strong> ${data.data.stock_quantity}</p>
                        <p><strong>Estado:</strong> ${data.data.stock_status}</p>
                        <p class="text-xs text-gray-500 mt-2">Endpoint: GET /api/products/${currentProductId}/check-stock</p>
                    `;
                } else {
                    resultsContent.innerHTML = `<p class="text-red-600">Error: ${data.message}</p>`;
                }
            } catch (error) {
                apiResults.classList.remove('hidden');
                resultsContent.innerHTML = `<p class="text-red-600">Error: ${error.message}</p>`;
            }
        });
        
        // Calcular descuento (API)
        calculateDiscountBtn.addEventListener('click', async function() {
            try {
                const discountPercentage = discountInput.value;
                
                // Asegurarse de que el token CSRF se está enviando correctamente
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(`/api/products/${currentProductId}/calculate-discount`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        discount_percentage: discountPercentage
                    })
                });
                
                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error(`Error en la respuesta del servidor: ${response.status} ${response.statusText}`);
                }
                
                const data = await response.json();
                
                apiResults.classList.remove('hidden');
                
                if (data.success) {
                    resultsContent.innerHTML = `
                        <p><strong>Producto:</strong> ${data.data.product.name}</p>
                        <p><strong>Precio original:</strong> $${parseFloat(data.data.original_price).toFixed(2)}</p>
                        <p><strong>Descuento:</strong> ${data.data.discount_percentage}%</p>
                        <p><strong>Precio con descuento:</strong> $${parseFloat(data.data.discounted_price).toFixed(2)}</p>
                        <p class="text-xs text-gray-500 mt-2">Endpoint: POST /api/products/${currentProductId}/calculate-discount</p>
                    `;
                } else {
                    resultsContent.innerHTML = `<p class="text-red-600">Error: ${data.message}</p>`;
                }
            } catch (error) {
                apiResults.classList.remove('hidden');
                resultsContent.innerHTML = `<p class="text-red-600">Error: ${error.message}</p>`;
                console.error('Error completo:', error);
            }
        });
        
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Cerrar modal al hacer clic fuera
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection