<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsolidacionesRequest extends FormRequest
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
        $id = $this->route()->parameter('consolidacion');

        return [
            'CNS_Debilidad' => 'required',
            'CNS_Fortaleza' => 'required',
            'PK_CRT_Id' => 'exists:TBL_Caracteristicas|numeric'
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
            'CNS_Debilidad.required' => 'Debilidad requerida.',
            'CNS_Fortaleza.required' => 'Fortaleza requerida.',
            'PK_CRT_Id.required' => 'El proceso es requerido',
            'PK_CRT_Id.numeric' => 'Proceso invalido.',
            'PK_CRT_Id.exists' => 'Este proceso no existe en nuestros registros.',
        ];
    }
}
