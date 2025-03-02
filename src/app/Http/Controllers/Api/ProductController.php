<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Models\Product;
use App\Services\ProductService;

/**
 * @OA\Info(
 *      title="Documentation API",
 *      version="1.0.0",
 *      description="Documentation for Product controller"
 * )
 */
class ProductController extends Controller
{
    public function __construct(protected ProductService $productService){ }

    /**
     * @OA\Get(
     *  path="/api/products",
     *  summary="Получение списка товаров",
     *  tags={"Products"},
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Pagination",
     *      required=false,
     *      @OA\Schema(type="integer", default=1),
     *      example=2 
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Успешный ответ",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Product")
     *      )
     *  )
     * )
     */
    public function index()
    {
        return $this->productService->getAll();
    }

    /**
     * @OA\Post(
     *  path="/api/products",
     *  summary="Create product",
     *  tags={"Products"},
     *  security={{"BearerToken":{}}},
     *  @OA\Response(
     *      response=201,
     *      description="Продукт успешно создан",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Product")
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Ошибка валидации"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type="object",
     *          required={"name", "price", "stock"},
     *          @OA\Property(
     *              property="name", 
     *              type="string", 
     *              example="Name"
     *          ),
     *          @OA\Property(
     *              property="description", 
     *              type="string",
     *              example="Some desc"
     *          ),
     *          @OA\Property(
     *              property="price", 
     *              type="number", 
     *              format="float", 
     *              example=100.05
     *          ),
     *          @OA\Property(
     *              property="stock", 
     *              type="integer", 
     *              example=1
     *          )
     *      )
     *  )
     * )
     */
    public function store(StoreRequest $request)
    {
        $product = $this->productService->create($request->all());

        return response()->json($product, 201);
    }

    /**
     * @OA\Get(
     *  path="/api/products/{$id}",
     *  summary="Получение одного товара",
     *  tags={"Products"},
     *  @OA\Response(
     *      response=200,
     *      description="Успешный ответ",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Product")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Продукт не найден"
     *  ),
     * )
     */
    public function show(Product $product)
    {
        return response()->json($this->productService->show($product));
    }
    
    /**
     * @OA\Put(
     *  path="api/products/{$id}",
     *  tags={"Products"},
     *  @OA\Response(
     *      response=200,
     *      description="Продукт успешно создан",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Product")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Продукт не найден"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type="object",
     *          required={"name", "price", "stock"},
     *          @OA\Property(
     *              property="name", 
     *              type="string", 
     *              example="Name"
     *          ),
     *          @OA\Property(
     *              property="description", 
     *              type="string",
     *              example="Some desc"
     *          ),
     *          @OA\Property(
     *              property="price", 
     *              type="number", 
     *              format="float", 
     *              example=100.05
     *          ),
     *          @OA\Property(
     *              property="stock", 
     *              type="integer", 
     *              example=1
     *          )
     *      )
     *  )
     * )
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product = $this->productService->update($product, $request->validated());
        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *  path="/api/products/{$id}",
     *  summary="Удаление товара",
     *  tags={"Products"},
     *  @OA\Response(
     *      response=200,
     *      description="Успешный ответ",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Product")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Продукт не найден"
     *  ),
     * )
     */
    public function destroy(Product $product)
    {
        return response()->json(['message' => 'Продукт успешно удален']);
    }
}
