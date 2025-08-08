<?php

namespace App\Http\Controllers\Api;

use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="Gestión de órdenes del restaurante"
 * )
 * 
*/

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     operationId="getOrders",
     *     tags={"Orders"},
     *     summary="Listar todas las órdenes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de órdenes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="client_name", type="string", example="Oran Kiehn I"),
     *                     @OA\Property(property="status", type="string", example="initiated"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-07T18:34:10Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-07T18:34:10Z"),
     *                     @OA\Property(
     *                         property="items",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="order_id", type="integer", example=1),
     *                             @OA\Property(property="description", type="string", example="consequatur aut"),
     *                             @OA\Property(property="quantity", type="integer", example=5),
     *                             @OA\Property(property="unit_price", type="string", example="28.45"),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-07T18:34:10Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-07T18:34:10Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */

    public function index(): JsonResponse
    {
        $data = [];
        $data["status"] = true ; 
        $data["data"] = $this->service->list() ; 
        return response()->json($data);
    }

    // /**
    //  * @OA\Post(
    //  *     path="/api/orders",
    //  *     operationId="storeOrder",
    //  *     tags={"Orders"},
    //  *     summary="Crear una nueva orden",
    //  *     @OA\RequestBody(
    //  *         required=true,
    //  *         @OA\JsonContent(ref="#/components/schemas/StoreOrderRequest")
    //  *     ),
    //  *     @OA\Response(
    //  *         response=201,
    //  *         description="Orden creada correctamente",
    //  *         @OA\JsonContent(
    //  *             ref="#/components/schemas/OrderResponse"
    //  *         )
    //  *     ),
    //  *     @OA\Response(response=422, ref="#/components/responses/ValidationError"),
    //  *     @OA\Response(response=500, ref="#/components/responses/ServerError"),
    //  *     @OA\Response(response=405, ref="#/components/responses/MethodNotAllowed")
    //  * )
    // */
        
    /**
     * @OA\Post(
     *     path="/api/orders",
     *     operationId="storeOrder",
     *     tags={"Orders"},
     *     summary="Crear una nueva orden",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"client_name", "items"},
     *             @OA\Property(property="client_name", type="string", example="Carlos Gómez"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"description", "quantity", "unit_price"},
     *                     @OA\Property(property="description", type="string", example="Lomo saltado"),
     *                     @OA\Property(property="quantity", type="integer", example=1),
     *                     @OA\Property(property="unit_price", type="number", format="float", example=60)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orden creada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/ValidationError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError"),
     *     @OA\Response(response=405, ref="#/components/responses/MethodNotAllowed")
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        // $data = [];
        // $data["status"] = true ; 
        // $data["data"] = $this->service->create($request->validated()) ; 
        // return response()->json($data, 201);
        return response()->json($this->service->create($request->validated()), 201);

    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     operationId="getOrderById",
     *     tags={"Orders"},
     *     summary="Obtener una orden por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la orden",
     *         @OA\Schema(type="integer", example="1")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la orden",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Order")
     *         )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */

    public function show(int $id): JsonResponse
    {
        $data = [];
        $data["status"] = true ; 
        $data["data"] = $this->service->get($id) ; 
        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/orders/{id}/advance",
     *     operationId="advanceOrder",
     *     tags={"Orders"},
     *     summary="Avanzar el estado de una orden",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la orden",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden actualizada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="message", type="string", example="Estado actualizado a En preparación")
     *         )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
     *     @OA\Response(response="422", ref="#/components/responses/ValidationError"),
     *     @OA\Response(response="500", ref="#/components/responses/ServerError"),
     *     @OA\Response(response="405", ref="#/components/responses/MethodNotAllowed") 
     * )
    */

    public function advance(int $id): JsonResponse
    {
        $data = [];
        $data["status"] = true ; 
        $data["data"] = [] ; 
        $data["message"] = $this->service->advance($id); 
        return response()->json($data);
    }
    
}
