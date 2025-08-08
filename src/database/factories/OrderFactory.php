<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class OrderFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */

    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'client_name' => $this->faker->name(),
            'status' => 'initiated',
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            OrderItem::factory()->count(3)->create([
                'order_id' => $order->id
            ]);
        });
    }


    
}
