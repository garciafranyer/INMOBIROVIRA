<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InmuebleUpdateRequest extends FormRequest
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
            'zona' => 'required|string|max:100',            
            'id_usuario' => 'required|string|max:100',            
            'id_tipo_inmueble' => 'required|string|max:100',            
            'id_municipio' => 'required|string|max:100'       
        ];
    }

    public function messages(): array{
        return[
        'nombre.required' => 'El nombre del municipio es obligatorio',
        'nombre.max' => 'El nombre del inmueble no puede superar los 100 caracteres',
        'zona.requerid' => 'la zona del del inmueble es obligatorio',
        'id_usuario.required' => 'el id del usuario es obligatorio',
        'id_tipo_inmueble.required' => 'el id del tipo de inmueble es obligatorio',
        'id_municipio.required' => 'el id del municipio es obligatorio',
        ];
    }
}
