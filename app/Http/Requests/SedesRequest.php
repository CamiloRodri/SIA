<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SedesRequest extends FormRequest
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
        $id = $this->route()->parameter('sede');

        return [
            'SDS_Nombre' => 'required|max:60|' . Rule::unique('TBL_Sedes')->ignore($id, 'PK_SDS_Id'),
            'SDS_Descripcion' => 'required',
            'PK_ESD_Id' => 'exists:TBL_Estados|numeric',
            'PK_ITN_Id' => 'exists:TBL_Estados|numeric'
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
            'SDS_Nombre.unique' => 'Esta sede ya ha sido registrada.',
            'SDS_Nombre.required' => 'Nombre requerido.',
            'PK_ESD_Id.required' => 'El estado es requerido',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
            'PK_ITN_Id.required' => 'La institución es requerida',
            'PK_ITN_Id.numeric' => 'Institución invalida.',
            'PK_ITN_Id.exists' => 'Esta institución no existe en nuestros registros.'
        ];
    }
}
