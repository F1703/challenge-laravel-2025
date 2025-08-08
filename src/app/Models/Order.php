<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     required={"id", "client_name", "status"},
 *     @OA\Property(property="id", type="integer", example=11),
 *     @OA\Property(property="client_name", type="string", example="Cliente recurrente"),
 *     @OA\Property(property="status", type="string", example="initiated"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-08T10:07:12.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-08T10:07:12.000000Z"),
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
