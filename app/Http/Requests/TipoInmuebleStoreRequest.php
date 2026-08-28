<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TipoInmuebleStoreRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return[
            'nombre.required'=>'El nombre del tipo de inmueble es obligatorio',
            'nombre.max'=>'El nombre del tipo de inmueble no puede superar los 100 carateres',
        ];
    }
}
