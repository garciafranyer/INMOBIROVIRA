<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BarrioUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'id_municipio' => 'required'
        ];
    }

    public function messages(): array{
        return[
        'nombre.required' => 'El nombre del municipio es obligatorio',
        'nombre.max' => 'El nombre del barrio no puede superar los 100 caracteres',
        'id_municipio.requerid' => 'El Id del municipio es obligatorio'
        ];
    }
}
