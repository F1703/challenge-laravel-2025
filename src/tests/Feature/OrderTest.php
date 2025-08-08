<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_can_list_active_orders(): void
    {
        // Crea 3 órdenes activas
        Order::factory()->count(3)->create(['status' => 'initiated']);

        // Crea 2 órdenes ya entregadas (no deben aparecer)
        Order::factory()->count(2)->create(['status' => 'delivered']);

        // Llamada al endpoint
        $response = $this->getJson('/api/orders');
        // $response->dump(); 

        // Verifica que la respuesta sea 200 OK
        $response->assertStatus(200, 'El endpoint /api/orders debe responder con código 200');

        // Verifica que solo se devuelvan las activas
        $response->assertJsonCount(3, 'data', 'Debe retornar solo las órdenes con status "initiated"');

        echo "\n✔ Test 'test_can_list_active_orders' ejecutado correctamente.\n";
        
    }
}
