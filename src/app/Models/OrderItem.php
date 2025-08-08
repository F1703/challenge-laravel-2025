<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="OrderItem",
 *     type="object",
 *     required={"description", "quantity", "unit_price"},
 *     @OA\Property(property="description", type="string", maxLength=500, example="items description 01"),
 *     @OA\Property(property="quantity", type="integer", minimum=1, example=4),
 *     @OA\Property(property="unit_price", type="number", format="float", minimum=0, example=2.0),
 * )
*/

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'description', 'quantity', 'unit_price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}
