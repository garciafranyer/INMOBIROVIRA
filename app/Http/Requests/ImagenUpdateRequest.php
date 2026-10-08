<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImagenUpdateRequest extends FormRequest
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
        'id_inmueble' => 'required|exists:inmueble,id',
        'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
    ];
}

    public function messages(): array
    {
        return[
            'ruta.required'=>'la ruta de la imagen es obligatorio',
            'url_imagen.required' => 'la ulr de la imagen es obligatorio',
            'id_inmueble.required' => 'El id del inmueble es obligatorio',  
        ];
    }
}
