<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // Datos del inmueble
            'nombre'           => 'required|string|max:100',
            'zona'             => ['required', Rule::in(['rural', 'urbana'])],
            'id_usuario'       => 'required|exists:usuario,id',
            'id_tipo_inmueble' => 'required|exists:tipo_inmueble,id',
            'id_municipio'     => 'required|exists:municipio,id',

            // Detalle del inmueble
            'detalle.direccion'            => 'required|string|max:255',
            'detalle.tipo_oferta'          => ['required', Rule::in(['venta', 'arriendo', 'venta y arriendo'])],
            'detalle.precio'               => 'required|numeric|min:0',
            'detalle.precio_administrador' => 'required|numeric|min:0',
            'detalle.area'                 => 'required|numeric|min:0',
            'detalle.numero_habitacion'    => 'nullable|integer|min:0',
            'detalle.numero_parqueadero'   => 'nullable|integer|min:0',
            'detalle.numero_piso'          => 'nullable|integer|min:0',
            'detalle.numero_apartamento'   => 'nullable|integer|min:0',
            'detalle.numero_bano'          => 'nullable|integer|min:0',
            'detalle.descripcion'          => 'required|string|max:255',
            'detalle.fecha_publicacion'    => 'required|date',
            'detalle.estado_publicacion'   => ['required', Rule::in(['disponible', 'arrendado', 'vendido', 'reservado', 'inactivo'])],

            // Imágenes nuevas (opcionales al editar)
            'imagenes'   => 'nullable|array|max:10',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            // Inmueble
            'nombre.required'           => 'El nombre del inmueble es obligatorio',
            'nombre.max'                => 'El nombre del inmueble no puede superar los 100 caracteres',
            'zona.required'             => 'La zona del inmueble es obligatoria',
            'zona.in'                   => 'La zona debe ser rural o urbana',
            'id_usuario.required'       => 'El usuario es obligatorio',
            'id_usuario.exists'         => 'El usuario seleccionado no existe',
            'id_tipo_inmueble.required' => 'El tipo de inmueble es obligatorio',
            'id_tipo_inmueble.exists'   => 'El tipo de inmueble seleccionado no existe',
            'id_municipio.required'     => 'El municipio es obligatorio',
            'id_municipio.exists'       => 'El municipio seleccionado no existe',

            // Detalle
            'detalle.direccion.required'            => 'La dirección es obligatoria',
            'detalle.tipo_oferta.required'          => 'El tipo de oferta es obligatorio',
            'detalle.tipo_oferta.in'                => 'El tipo de oferta no es válido',
            'detalle.precio.required'               => 'El precio es obligatorio',
            'detalle.precio.numeric'                => 'El precio debe ser un número',
            'detalle.precio_administrador.required' => 'El precio de administración es obligatorio',
            'detalle.precio_administrador.numeric'  => 'El precio de administración debe ser un número',
            'detalle.area.required'                 => 'El área es obligatoria',
            'detalle.area.numeric'                  => 'El área debe ser un número',
            'detalle.descripcion.required'          => 'La descripción es obligatoria',
            'detalle.descripcion.max'               => 'La descripción no puede superar los 255 caracteres',
            'detalle.fecha_publicacion.required'    => 'La fecha de publicación es obligatoria',
            'detalle.fecha_publicacion.date'        => 'La fecha de publicación no es válida',
            'detalle.estado_publicacion.required'   => 'El estado de publicación es obligatorio',
            'detalle.estado_publicacion.in'         => 'El estado de publicación no es válido',

            // Imágenes
            'imagenes.max'        => 'Máximo 10 imágenes por vez',
            'imagenes.*.uploaded' => 'No se pudo subir una imagen. Puede superar el tamaño permitido',
            'imagenes.*.image'    => 'Cada archivo debe ser una imagen',
            'imagenes.*.mimes'    => 'Formatos permitidos: jpg, jpeg, png, webp',
            'imagenes.*.max'      => 'Cada imagen puede pesar máximo 5 MB',
        ];
    }
}