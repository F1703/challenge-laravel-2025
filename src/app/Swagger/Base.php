<?php 

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Order Management API",
 *     version="1.0.0",
 *     description="API para la gestión de órdenes de restaurante. Permite crear órdenes con sus ítems, listar órdenes activas, avanzar en su estado ('initiated' → 'sent' → 'delivered') y eliminarlas automáticamente cuando se entregan.",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local de desarrollo"
 * )
*/

class Base
{
    // Esta clase sólo existe para contener las anotaciones generales de OpenAPI
}
