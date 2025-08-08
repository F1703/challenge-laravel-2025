<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });



        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [], 
                    'message' => 'Datos inválidos.' ,
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        $this->renderable(function (ModelNotFoundException|NotFoundHttpException $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [], 
                    'message' => 'Recurso no encontrado',
                ], 404);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Método HTTP no permitido para esta ruta.',
                ], 405);
            }
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/documentation') || $request->is('api-docs.json')) {
                return; 
            }

            if ($request->expectsJson() || $request->is('api/*')) {

                // cualquier otro tipo de excepcion capturar y crear log. (para luego crear una respuesta personalizada)
                Log::error('Excepción no capturada:', [
                    'class' => get_class($e),
                    'message' => $e->getMessage(),
                ]);

                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Error interno del servidor',
                ], 500);
            }
            
           
        });




    }
}
