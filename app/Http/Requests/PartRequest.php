<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $partId = $this->route('part');
        if (!$partId) {
            $partId = $this->route('id');
        }

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('parts', 'code')->ignore($partId)
            ],
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            // 'manages_stock' es un campo virtual del form para decidir validación
            'manages_stock' => 'required|boolean',
            'current_price' => 'required|numeric|min:0',
            'stock' => 'required_if:manages_stock,true|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Este código de repuesto ya está registrado.',
            'stock.required_if' => 'Si el repuesto maneja stock, debes indicar la cantidad inicial.',
            'current_price.min' => 'El precio no puede ser un valor negativo.',
        ];
    }
}
