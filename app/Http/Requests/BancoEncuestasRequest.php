<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BancoEncuestasRequest extends FormRequest
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
            'BEC_Nombre' => 'required|string',
            'BEC_Descripcion' => 'required',
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
            'BEC_Nombre.required' => 'El campo nombre es requerido',
            'BEC_Descripcion' => 'El campo descripción es requerido',
        ];
    }
}
