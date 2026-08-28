<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MunicipioStoreRequest extends FormRequest
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
            'nombre' =>'required|string',
            'codigo_postal' =>'required|string'
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.required'=>'El nombre del municipio obligatorio',
            'nombre.max'=>'El nombre del municipio no puede superar los 100 carateres',
            'codigo_postal.required' => 'El codigo postal es obligatorio',
            'codigo_postal.max' => 'El codigo postal no puede superar los 10 caracteres'
        ];
    }
}
