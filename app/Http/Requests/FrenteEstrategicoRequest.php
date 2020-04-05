<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrenteEstrategicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'FES_Nombre' => 'required|string|max:60',
            'FES_Descripcion' => 'required|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'FES_Nombre.required' => 'El campo es requerido',
            'FES_Descripcion.required' => 'El campo es requerido'
        ];
    }
}
