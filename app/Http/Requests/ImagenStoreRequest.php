<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImagenStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inmueble' => 'required|exists:inmueble,id',
            'imagenes'    => 'required|array|max:10',
            'imagenes.*'  => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'id_inmueble.required' => 'El inmueble es obligatorio',
            'id_inmueble.exists'   => 'El inmueble seleccionado no existe',
            'imagenes.required'    => 'Debes seleccionar al menos una imagen',
            'imagenes.array'       => 'Las imágenes no se enviaron correctamente',
            'imagenes.max'         => 'Máximo 10 imágenes por vez',
            'imagenes.*.image'     => 'Cada archivo debe ser una imagen',
            'imagenes.*.mimes'     => 'Formatos permitidos: jpg, jpeg, png, webp',
            'imagenes.*.max'       => 'Cada imagen puede pesar máximo 2 MB',
        ];
    }
}
