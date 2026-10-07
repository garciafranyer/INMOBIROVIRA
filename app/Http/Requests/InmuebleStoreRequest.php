<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InmuebleStoreRequest extends FormRequest
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
    { return [
            'nombre' => 'required|string|max:100',            
            'zona' => 'required|string|max:100',            
            'id_usuario' => 'required|string|max:100',            
            'id_tipo_inmueble' => 'required|string|max:100',            
            'id_municipio' => 'required|string|max:100',  
            
            


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
