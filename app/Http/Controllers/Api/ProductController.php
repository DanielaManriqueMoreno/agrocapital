<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function checkStock($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        $stockStatus = $product->stock > 0 ? 'Disponible' : 'Agotado';
        
        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product->name,
                'stock_quantity' => $product->stock,
                'stock_status' => $stockStatus
            ]
        ]);
    }

    public function calculateDiscount(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        $discountPercentage = $request->input('discount_percentage', 0);
        $originalPrice = $product->price;
        $discountedPrice = $originalPrice - ($originalPrice * ($discountPercentage / 100));
        
        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'original_price' => $originalPrice,
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice
            ]
        ]);
    }
}
