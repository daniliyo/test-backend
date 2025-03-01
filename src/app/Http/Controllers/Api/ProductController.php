<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService){ }

    public function index()
    {
        return $this->productService->getAll();
    }

    public function store(StoreRequest $request)
    {
        $product = $this->productService->create($request->all());

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($this->productService->show($product));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $product = $this->productService->update($product, $request->validated());
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        return response()->json(['message' => 'Продукт успешно удален']);
    }
}
