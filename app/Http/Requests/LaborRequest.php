<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaborRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $laborId = $this->route('labor');

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'standard_price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Este código de labor ya está registrado.',
            'standard_price.required' => 'Debes definir un precio estándar.',
        ];
    }
}
