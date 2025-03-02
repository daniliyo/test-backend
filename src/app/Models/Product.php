<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *  schema="Product",
 *  title="Product",
 *  description="Some description for product schema",
 *  @OA\Property(
 *      property="id",
 *      type="integer",
 *      description="Ид товара",
 *      example=1
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string",
 *      description="Название товара",
 *      example="Продукт 1",
 *  ),
 *  @OA\Property(
 *      property="description",
 *      type="string",
 *      description="Description product",
 *      example="Some description"
 *  ),
 *  @OA\Property(
 *      property="price",
 *      type="number",
 *      format="float",
 *      description="price product",
 *      example=100.05
 *  ),
 *  @OA\Property(
 *      property="stock",
 *      type="integer",
 *      description="Stock product",
 *      example=1
 *  ),
 *  @OA\Property(
 *      property="created_at",
 *      type="timestamp",
 *      description="Data created products",
 *      example="2025-03-02T12:00:00Z"
 *  ),
 *  @OA\Property(
 *      property="updated_at",
 *      type="timestamp",
 *      description="Date updated product",
 *      example="2025-03-02T12:00:00Z"
 *  )
 * )
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
}
