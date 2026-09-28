<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DetalleInmuebleUpdateRequest extends FormRequest
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
        'direccion' => 'required',
        'tipo_oferta' => 'required',
        'precio' => 'required',
        'precio_administrador' => 'required',
        'area' => 'required',
        'numero_habitacion' => 'nullable',
        'numero_parqueadero' => 'nullable',
        'numero_piso' => 'nullable',
        'numero_apartamento' => 'nullable',
        'numero_bano' => 'nullable',
        'descripcion' => 'required',
        'fecha_publicacion' => 'required|date',
        'estado_publicacion' => 'required',
        'id_inmueble' => 'required|exists:inmueble,id',
        ];
    }
}
