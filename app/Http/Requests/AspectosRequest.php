<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AspectosRequest extends FormRequest
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
            'ASP_Nombre' => 'required|string',
            'ASP_Descripcion' => 'required',
            'ASP_Identificador' => 'required|' . Rule::unique('TBL_Aspectos', 'ASP_Identificador')
                    ->where('FK_ASP_Caracteristica', $this->request->get('PK_CRT_Id')),
            'PK_CRT_Id' => 'required|exists:TBL_Caracteristicas'
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
            'PK_CRT_Id.required' => 'Debe seleccionar una característica.',
            'PK_CRT_Id.exists' => 'La característica que selecciona no existe en nuestros registros.',
            'ASP_Identificador.unique' => 'El identificador que ingreso ya ha sido registrado.',
            'ASP_Nombre.required' => 'El campo nombre es requerido',
            'ASP_Descripcion' => 'El campo descripción es requerido',
            'PK_CRT_Id' => 'La característica que selecciono no se encuentra en nuestros registros.'

        ];
    }
}
