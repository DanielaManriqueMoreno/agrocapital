<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name'=>'Maiz',
                'Description'=>'Maiz cultivado por campesinos colombianos',
                'Category'=>'Cultivos',
                'price'=>5000,
                'Stock'=>100,
                'image'=>'maiz.jpg'
            ],
            [
                'name' => 'Tomates frescos',
                'description' => 'Tomates recién cosechados de cultivos locales',
                'category' => 'Verduras',
                'price' => 1500,
                'stock' => 150,
                'image' => 'tomate.webp'
            ],
            [
                'name' => 'Manzanas rojas',
                'description' => 'Manzanas dulces y jugosas',
                'category' => 'Frutas',
                'price' => 2000,
                'stock' => 200,
                'image' => 'manzana.jpeg'
            ],
            [
                'name' => 'Arroz blanco',
                'description' => 'Arroz blanco de alta calidad',
                'category' => 'Cereales',
                'price' => 3000,
                'stock' => 80,
                'image' => 'arroz.webp'
            ],
            [
                'name' => 'Zanahorias',
                'description' => 'Zanahorias frescas cultivadas localmente',
                'category' => 'Verduras',
                'price' => 1700,
                'stock' => 120,
                'image' => 'zanahoria.jpg'
            ],
            [
                'name' => 'marañon',
                'description' => 'marañon fresco y dulce de campesinos locales',
                'category' => 'Frutas',
                'price' => 2000,
                'stock' => 300,
                'image' => 'marañon.webp'
            ],
            [
                'name' => 'mangostino',
                'description' => 'mangostino con mucha carne y dulce',
                'category' => 'Frutas',
                'price' => 2500,
                'stock' => 100,
                'image' => 'mangostino.jpg'
            ],
            [
                'name' => 'repollo',
                'description' => 'repollo fresco y crujiente',
                'category' => 'Verduras',
                'price' => 1200,
                'stock' => 120,
                'image' => 'repollo.webp'
            ],
        ];
        foreach ($products as $product){
            Product::create($product);
        }
    }
}
