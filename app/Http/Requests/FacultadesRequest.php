<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class FacultadesRequest extends FormRequest
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
        $id = $this->route()->parameter('facultade');
        return [
            'FCD_Nombre' => 'required|max:60|' . Rule::unique('TBL_Facultades')->ignore($id, 'PK_FCD_Id'),
            'FCD_Descripcion' => 'required',
            'PK_ESD_Id' => 'exists:TBL_Estados|numeric'
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
            'FCD_Nombre.unique' => 'Esta facultad ya ha sido registrada.',
            'FCD_Nombre.required' => 'Nombre requerido.',
            'FCD_Descripcion.required' => 'Una descripcion es requerida',
            'PK_ESD_Id.required' => 'El estado es requerido',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
        ];
    }
}
