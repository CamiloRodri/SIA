<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstitucionRequest extends FormRequest
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
            'ITN_Nombre' => 'required',
            'ITN_Domicilio' => 'required',
            'ITN_Caracter' => 'required',
            'ITN_CodigoSNIES' => 'required',
            'ITN_Norma_Creacion' => 'required'
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
            'ITN_Nombre.required' => 'el campo nombre requerido.',
            'ITN_Domicilio.required' => 'el campo nombre requerido.',
            'ITN_Caracter.required' => 'el campo nombre requerido.',
            'ITN_CodigoSNIES.required' => 'el campo nombre requerido.',
            'ITN_Norma_Creacion.required' => 'el campo nombre requerido.'
        ];
    }
}
