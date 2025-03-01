<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_create_product()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Some name',
            'description' => 'ssome desc',
            'price' => 100.05,
            'stock' => 10,
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'name', 'description', 'price', 'stock']);
    }
}
