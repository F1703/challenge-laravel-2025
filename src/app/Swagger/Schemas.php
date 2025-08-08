<?php  

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="OrderResponse",
 *     type="object",
 *     required={"order", "total"},
 *     @OA\Property(
 *         property="order",
 *         ref="#/components/schemas/Order"
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="number",
 *         format="float",
 *         example=8
 *     )
 * )
*/

class Schemas
{
    // Esta clase sólo existe para contener las anotaciones generales de OpenAPI
}




