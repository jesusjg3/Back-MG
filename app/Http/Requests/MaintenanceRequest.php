<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'kilometraje' => 'required|integer|min:0',
            // permite que sea igual o mayor (gte) en lugar de estrictamente mayor
            'prox_kilometraje' => 'nullable|integer|gte:kilometraje',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // Validar los arrays de la pivot
            'parts' => 'nullable|array',
            'parts.*.id' => 'required|exists:parts,id',
            'parts.*.quantity' => 'required|integer|min:1',
            'parts.*.price_at_time' => 'required|numeric|min:0', // Ajustado a nombre en BD/Repo

            'labors' => 'nullable|array',
            'labors.*.id' => 'required|exists:labors,id',
            'labors.*.cost_at_time' => 'required|numeric|min:0', // Ajustado a nombre en BD/Repo
        ];
    }

    public function messages(): array
    {
        return [
            'prox_kilometraje.gte' => 'El próximo kilometraje debe ser mayor o igual al actual.',
            'parts.*.id.exists' => 'Uno de los repuestos seleccionados no es válido.',
            'vehicle_id.exists' => 'El vehículo seleccionado no existe en el sistema.',
        ];
    }
}
