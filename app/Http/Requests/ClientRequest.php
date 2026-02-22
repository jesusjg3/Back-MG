<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtenemos el ID del cliente si estamos en una ruta de actualización
        // Asumiendo que la ruta usa parameter binding 'client' o el ID directamente
        // Intentamos obtener el ID del cliente de varias formas posibles
        $clientId = $this->route('client');
        if (!$clientId) {
            $clientId = $this->route('id');
        }

        return [
            'name' => 'required|string|max:255',
            // Agregamos ignore para permitir actualizar el mismo cliente sin error de "ya existe"
            'ci' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients', 'ci')->ignore($clientId)
            ],
            'phone' => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'ci.unique' => 'Este número de cédula ya está registrado.',
        ];
    }
}
