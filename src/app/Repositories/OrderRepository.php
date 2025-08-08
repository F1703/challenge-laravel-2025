<?php 
namespace App\Repositories; 

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getActive(): Collection
    {
        return Order::with('items')
            ->where('status', '!=', 'delivered')
            ->orderBy("id","desc")
            ->get();
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'client_name' => $data['client_name'],
                'status' => 'initiated'
            ]);

            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }

            return $order;
        });
    }

    public function find(int $id): Order
    {
        return Order::with('items')->findOrFail($id);
    }

    public function save(Order $order): void
    {
        $order->save();
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
}

