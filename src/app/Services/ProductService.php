<?php

namespace App\Services;

use App\Models\Product;

class ProductService 
{

    public function getAll()
    {
        return Product::paginate(5);
    }
    
    public function show(Product $product): Product
    {
        return $product;
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);
        return $product;
    }

    public function update(Product $product, array $data): Product{
        $product->update($data);
        return $product;
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }
}