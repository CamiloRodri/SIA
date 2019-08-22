<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class FactoresRequest extends FormRequest
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
        $id = $this->route()->parameter('factore');
        return [
            'FCT_Nombre' => 'required',
            'FCT_Descripcion' => 'required',
            'FCT_Identificador' => 'required|numeric|' . Rule::unique('TBL_Factores', 'FCT_Identificador')
                    ->where('FK_FCT_Lineamiento', $this->request->get('FK_FCT_Lineamiento'))->ignore($id, 'PK_FCT_Id'),
            'FCT_Ponderacion_factor' => 'required|numeric',
            'FK_FCT_Estado' => 'exists:TBL_Estados,PK_ESD_Id',
            'FK_FCT_Lineamiento' => 'exists:TBL_Lineamientos,PK_LNM_Id'
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
            'FCT_Nombre.required' => 'el campo nombre requerido.',
            'FCT_Descripcion.required' => 'el campo descripción requerido.',
            'FCT_Identificador.required' => 'el campo identificador es requerido.',
            'FCT_Identificador.numeric' => 'el campo identificador deber ser numérico.',
            'FCT_Identificador.unique' => 'El identificador que ingreso ya ha sido registrado.',
            'FCT_Ponderacion_factor.required' => 'el campo ponderación es requerido.',
            'FCT_Ponderacion_factor.numeric' => 'el campo ponderación deber ser numérico.',
            'FK_FCT_Estado.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'FK_FCT_Lineamiento' => 'El Lineamiento que selecciono no se encuentra en nuestros registros'
        ];
    }
}
