<?php 

namespace App\Services;

use Exception;
use App\Models\Order;
use Illuminate\Support\Collection;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Cache;

class OrderService
{
    public function __construct(
        protected OrderRepository $repo
    ) {}

    public function list(): Collection
    {
        return Cache::remember('orders.active', 30, function () {
            return $this->repo->getActive();
        });
    }

    public function create(array $data): array
    {
        Cache::forget('orders.active');
        $order = $this->repo->create($data);
        $order->load('items');
        $total = $order->items->sum(fn($item) => $item->quantity * $item->unit_price);

        return [
            'order' => $order,
            'total' => $total,
        ];
        
        // return $this->repo->create($data);
    }

    public function get(int $id): array
    {
        $order = $this->repo->find($id);
        $total = $order->items->sum(fn($item) => $item->quantity * $item->unit_price);
        return [
            'order' => $order,
            'total' => $total
        ];
    }

    public function advance(int $id): string
    {
        $order = $this->repo->find($id);
        $next = [
            'initiated' => 'sent',
            'sent' => 'delivered'
        ];

        if (!isset($next[$order->status])) {
            throw new Exception('Transición inválida');
        }

        $newStatus = $next[$order->status];

        if ($newStatus === 'delivered') {
            $this->repo->delete($order);
            Cache::forget('orders.active');
            return "Orden entregada y eliminada";
        } 

        $order->status = $newStatus;
        $this->repo->save($order);

        Cache::forget('orders.active');
        return "Orden actualizada a $newStatus";
    }
}

