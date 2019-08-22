<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DatosEncuestasRequest extends FormRequest
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
        $id = $this->route()->parameter('datosEncuesta');
        $datos = 'unique:TBL_Datos_Encuestas,fk_dae_gruposinteres';

        if ($this->method() == 'PUT') {
            $datos = Rule::unique('TBL_Datos_Encuestas', 'fk_dae_gruposinteres')->ignore($id, 'PK_DAE_Id');
        }
        return [
            'DAE_Titulo' => 'required|string',
            'DAE_Descripcion' => 'required',
            'PK_GIT_Id' => 'required|exists:TBL_Grupos_Interes',
            'PK_GIT_Id' => $datos
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
            'PK_GIT_Id.required' => 'Debe seleccionar un grupo de interes.',
            'PK_GIT_Id.exists' => 'El grupo de interes que selecciona no existe en nuestros registros.',
            'PK_GIT_Id.unique' => 'Ya existen datos relacionados al grupo de interes seleccionado.',
        ];
    }
}
