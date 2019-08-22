<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaracteristicasRequest extends FormRequest
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
        $id = $this->route()->parameter('caracteristica');

        return [
            'CRT_Nombre' => 'required',
            'CRT_Descripcion' => 'required',
            'CRT_Identificador' => 'required|numeric|' . Rule::unique('TBL_Caracteristicas', 'CRT_Identificador')->ignore($id, 'PK_CRT_Id'),
            'FK_FCT_Lineamiento' => 'exists:TBL_Lineamientos,PK_LNM_Id',
            'FK_CRT_Factor' => 'exists:TBL_Factores,PK_FCT_Id',
            'FK_CRT_Estado' => 'exists:TBL_Estados,PK_ESD_Id',
            'FK_CRT_Ambito' => 'exists:TBL_Ambitos_Responsabilidad,PK_AMB_Id'
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
            'CRT_Nombre.required' => 'el campo nombre requerido.',
            'CRT_Descripcion.required' => 'el campo descripción requerido.',
            'CRT_Identificador.required' => 'el campo identificador es requerido.',
            'CRT_Identificador.numeric' => 'el campo identificador deber ser numérico.',
            'CRT_Identificador.unique' => 'El identificador que ingreso ya ha sido registrado.',
            'FK_CRT_Estado.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'FK_FCT_Lineamiento.exists' => 'El Lineamiento que selecciono no se encuentra en nuestros registros',
            'FK_CRT_Factor.exists' => 'El Factor que selecciono no se encuentra en nuestros registros',
            'FK_CRT_Ambito.exists' => 'El Ámbito que selecciono no se encuentra en nuestros registros',
        ];
    }
}
