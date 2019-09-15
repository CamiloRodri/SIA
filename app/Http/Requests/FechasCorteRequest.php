<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FechasCorteRequest extends FormRequest
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
        $id = $this->route()->parameter('fechacorte');

        return [
            'FCO_Fecha' => 'required',
            'PK_PCS_Id' => 'exists:TBL_Procesos|numeric'
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
            'FCO_Fecha.required' => 'Fecha requerida.',
            'PK_PCS_Id.required' => 'El proceso es requerido',
            'PK_PCS_Id.numeric' => 'Proceso invalido.',
            'PK_PCS_Id.exists' => 'Este proceso no existe en nuestros registros.',
        ];
    }
}
