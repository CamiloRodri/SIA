<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GruposInteresRequest extends FormRequest
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
        $id = $this->route()->parameter('grupos_intere');
        return [
            'GIT_Nombre' => 'required|max:60|' . Rule::unique('TBL_Grupos_Interes')->ignore($id, 'PK_GIT_Id'),
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
            'GIT_Nombre.unique' => 'Este grupo de interes ya ha sido registrado.',
            'GIT_Nombre.required' => 'Nombre requerido.',
            'PK_ESD_Id.required' => 'El estado es requerido',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
        ];
    }
}
