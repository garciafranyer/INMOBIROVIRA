<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
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
            'gmail' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'tipo_usuario' => 'required',
            'nombre_empresa' =>'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.required'=>'El nombre del usuario es obligatorio',
            'nombre.max'=>'El nombre del usuario no puede superar los 100 carateres',
            'gmail.required' => 'El gmail es obligatorio',
            'gmail.max' => 'El gmail no puede superar los 100 caracteres',
            'telefono.required' => 'El numero de telefono es obligatorio ',
            'telefono.max' => 'El numero de telefono no puede superar los 20 caracteres',
            'direccion.required' => 'La direccion es obligatoria',
            'tipo_usuario.required' => 'El tipo de usuario es obligatorio',   
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio',
            'nombre_empresa.max' => 'El nombre de la empresa no puede superar los 100 caracteres',  
                   

        ];
    }
}
