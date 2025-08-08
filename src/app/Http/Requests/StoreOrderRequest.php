<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



/**
 * @OA\Schema(
 *     schema="StoreOrderRequest",
 *     type="object",
 *     required={"client_name", "items"},
 *     @OA\Property(property="client_name", type="string", example="Cliente recurrente"),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"description", "quantity", "unit_price"},
 *             @OA\Property(property="description", type="string", maxLength=500, example="items description 01"),
 *             @OA\Property(property="quantity", type="integer", minimum=1, example=4),
 *             @OA\Property(property="unit_price", type="number", format="float", minimum=0, example=2.0)
 *         )
 *     )
 * )
 */


class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:500',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'El nombre del cliente es obligatorio.',
            'client_name.string' => 'El nombre del cliente debe ser una cadena de texto.',
            'client_name.max' => 'El nombre del cliente no debe superar los 255 caracteres.',

            'items.required' => 'Debes proporcionar al menos un ítem en la orden.',
            'items.array' => 'El campo de ítems debe ser un arreglo.',
            'items.min' => 'La orden debe contener al menos un ítem.',

            'items.*.description.required' => 'Cada ítem debe tener una descripción.',
            'items.*.description.string' => 'La descripción del ítem debe ser una cadena de texto.',
            'items.*.description.max' => 'La descripción del ítem no debe superar los 500 caracteres.',

            'items.*.quantity.required' => 'Cada ítem debe tener una cantidad.',
            'items.*.quantity.integer' => 'La cantidad del ítem debe ser un número entero.',
            'items.*.quantity.min' => 'La cantidad mínima permitida para un ítem es 1.',

            'items.*.unit_price.required' => 'Cada ítem debe tener un precio unitario.',
            'items.*.unit_price.numeric' => 'El precio unitario debe ser un número.',
            'items.*.unit_price.min' => 'El precio unitario debe ser igual o mayor a 0.'
        ];
    }



    public function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'status' => false,
            'message' => 'Datos inválidos',
            'errors' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }


}
