<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehicleId = $this->route('vehicle');

        return [
            'client_id' => 'required|exists:clients,id',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles', 'plate')
                    ->ignore($vehicleId)
                    ->whereNull('deleted_at')
            ],
            'kilometraje' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.exists' => 'El cliente seleccionado no existe en el sistema.',
            'plate.unique' => 'Esta placa ya está registrada en otro vehículo.',
        ];
    }
}
