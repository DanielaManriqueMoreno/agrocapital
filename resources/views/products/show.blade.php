@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-green-600 hover:underLine mb-4 inLine-block">
            &larr; Volver a la lista de productos    
        </a>

        <div class="bg-white rounded-lg shadow overflow-hidden"> 
            <div class="md:flex">
                <div class="md:w-1/2">
                    <div class="h-96 bg-gray-200">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <span>Sin imagen</span>
                            </div>
                        @endif    
                    </div>    
                </div>    
                <div class="p-6 md:w-1/2">
                    <h2 class="text-3xl font-bold mb-4"> {{ $product->name}} </h2>
                    <p class="text-600 mb-2">Categoria: {{ $product->category}} </p>
                    <p class="text-gray-600 font-bold text-2xl mb-4">${{ number_format($product->price, 2)}} </p>
                    <p class="text-gray-500 mb-4"> Stock: {{$product->stock}} Unidades </p>
                    
                    <div class="border-t pt-4 mt-4">
                        <h3 class="text-xl font-semibold mb-2">Descripcion</h3>
                        <p class="text-gray-700"> {{ $product->description}} </p> 
                    </div>
                    
                    <div class="w-full md:w-1/2">
                        <p class="text-gray-600 mb-2">Categoría: <span id="modal-category"></span></p>
                        <p class="text-green-600 font-bold text-xl mb-2">$<span id="modal-price"></span></p>
                        <p class="text-gray-500 mb-4">Stock: <span id="modal-stock"></span> unidades</p>
                        <p class="text-gray-700 mb-4"><span id="modal-description"></span></p>
                        
                        <!-- Botones para probar las APIs -->
                        <!-- Botones para funcionalidades -->
                        <div class="mt-6 space-y-3">
                            <button id="check-stock-btn" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 w-full">
                                Verificar disponibilidad
                            </button>
                            
                            <div class="flex space-x-2">
                                <input type="number" id="discount-input" min="0" max="100" value="10" class="border rounded p-2 w-1/3" placeholder="% descuento">
                                <button id="calculate-discount-btn" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 flex-1">
                                    Calcular descuento
                                </button>
                            </div>
                            
                            <!-- Botones para APIs (opcional) -->
                            <div class="mt-4 pt-4 border-t">
                                <h4 class="text-sm font-semibold mb-2">Opciones con API:</h4>
                                <button id="check-stock-api-btn" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 w-full mb-2">
                                    Verificar disponibilidad (API)
                                </button>
                                
                                <div class="flex space-x-2">
                                    <button id="calculate-discount-api-btn" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 flex-1">
                                        Calcular descuento (API)
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resultados de las APIs -->
                        <div id="api-results" class="mt-4 p-4 bg-gray-100 rounded hidden">
                            <h4 class="font-semibold mb-2">Resultados:</h4>
                            <div id="results-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado, configurando event listeners');
        
        // Botones de funcionalidad local
        const checkStockBtn = document.getElementById('check-stock-btn');
        const calculateDiscountBtn = document.getElementById('calculate-discount-btn');
        
        // Botones de API (opcional)
        const checkStockApiBtn = document.getElementById('check-stock-api-btn');
        const calculateDiscountApiBtn = document.getElementById('calculate-discount-api-btn');
        
        const discountInput = document.getElementById('discount-input');
        const apiResults = document.getElementById('api-results');
        const resultsContent = document.getElementById('results-content');
        
        // Datos del producto disponibles desde la vista
        const productData = {
            id: {{ $product->id }},
            name: "{{ $product->name }}",
            price: {{ $product->price }},
            stock: {{ $product->stock }}
        };
        
        // Verificar stock (sin API)
        checkStockBtn.addEventListener('click', function() {
            const stockStatus = productData.stock > 0 ? 'Disponible' : 'Agotado';
            
            apiResults.classList.remove('hidden');
            resultsContent.innerHTML = `
                <p><strong>Producto:</strong> ${productData.name}</p>
                <p><strong>Cantidad en stock:</strong> ${productData.stock}</p>
                <p><strong>Estado:</strong> ${stockStatus}</p>
            `;
        });
        
        // Calcular descuento (sin API)
        calculateDiscountBtn.addEventListener('click', function() {
            const discountPercentage = parseFloat(discountInput.value) || 0;
            const originalPrice = productData.price;
            const discountAmount = originalPrice * (discountPercentage / 100);
            const discountedPrice = originalPrice - discountAmount;
            
            apiResults.classList.remove('hidden');
            resultsContent.innerHTML = `
                <p><strong>Producto:</strong> ${productData.name}</p>
                <p><strong>Precio original:</strong> $${originalPrice.toFixed(2)}</p>
                <p><strong>Descuento (${discountPercentage}%):</strong> $${discountAmount.toFixed(2)}</p>
                <p><strong>Precio final:</strong> $${discountedPrice.toFixed(2)}</p>
            `;
        });
        
        // Funcionalidad de API (opcional)
        if (checkStockApiBtn) {
            checkStockApiBtn.addEventListener('click', async function() {
                try {
                    apiResults.classList.remove('hidden');
                    resultsContent.innerHTML = '<p>Consultando API...</p>';
                    
                    // Usar la ruta correcta para la API
                    const response = await fetch(`/api/products/${productData.id}/check-stock`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        resultsContent.innerHTML = `
                            <p><strong>Producto (API):</strong> ${data.data.product}</p>
                            <p><strong>Cantidad en stock:</strong> ${data.data.stock_quantity}</p>
                            <p><strong>Estado:</strong> ${data.data.stock_status}</p>
                        `;
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    resultsContent.innerHTML = `<p class="text-red-600">Error API: ${error.message}</p>`;
                }
            });
        }
        
        if (calculateDiscountApiBtn) {
            calculateDiscountApiBtn.addEventListener('click', async function() {
                try {
                    const discountPercentage = parseFloat(discountInput.value) || 0;
                    
                    apiResults.classList.remove('hidden');
                    resultsContent.innerHTML = '<p>Consultando API...</p>';
                    
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    const response = await fetch(`/api/products/${productData.id}/calculate-discount`, {
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
                    
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        resultsContent.innerHTML = `
                            <p><strong>Producto (API):</strong> ${data.data.product.name}</p>
                            <p><strong>Precio original:</strong> $${parseFloat(data.data.original_price).toFixed(2)}</p>
                            <p><strong>Descuento (${data.data.discount_percentage}%):</strong> $${(data.data.original_price * (data.data.discount_percentage / 100)).toFixed(2)}</p>
                            <p><strong>Precio final:</strong> $${parseFloat(data.data.discounted_price).toFixed(2)}</p>
                        `;
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    resultsContent.innerHTML = `<p class="text-red-600">Error API: ${error.message}</p>`;
                }
            });
        }
        
        console.log('Event listeners configurados');
    });
</script>
@endsection