<?php

namespace App\Http\Controllers\Api;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('products.index',compact('products','categories'));
    }

    public function show($id){
        $product = Product::findOrFail($id);
        return view ('products.show',compact('product'));
    }
}
