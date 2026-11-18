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
            'imagenes.*'  => 'image|mimes:jpg,jpeg,png,webp|max:3048',
        ];
    }

    public function messages(): array
    {
        return [
            'id_inmueble.required' => 'El inmueble es obligatorio',
            'id_inmueble.exists'   => 'El inmueble seleccionado no existe',
            'imagenes.required'    => 'Debes seleccionar al menos una imagen',
            'imagenes.array'       => 'Las imágenes no se enviaron correctamente',
            'imagenes.max'         => 'El límite máximo permitido es de 10 imágenes por inmueble.',
            'imagenes.*.image'     => 'Cada archivo debe ser una imagen',
            'imagenes.*.mimes'     => 'Formatos permitidos: jpg, jpeg, png, webp',
            'imagenes.*.max'       => 'Cada imagen puede pesar máximo 2 MB',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('id_inmueble') && $this->hasFile('imagenes')) {
                $existentes = \App\Models\Imagen::where('id_inmueble', $this->id_inmueble)->count();
                $nuevas = count($this->file('imagenes', []));

                if (($existentes + $nuevas) > 10) {
                    $disponibles = max(0, 10 - $existentes);
                    $mensaje = $disponibles > 0
                        ? "Este inmueble ya tiene {$existentes} fotos. Solo puedes agregar hasta {$disponibles} fotos más (límite máximo: 10 imágenes)."
                        : 'Este inmueble ya alcanzó el límite máximo de 10 fotos. Debes eliminar fotos existentes antes de subir nuevas.';
                    $validator->errors()->add('imagenes', $mensaje);
                }
            }
        });
    }
}
