<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     required={"client_name"},
 *     @OA\Property(property="client_name", type="string", example="Cliente recurrente"),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OrderItem")
 *     )
 * )
 */

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_name', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
