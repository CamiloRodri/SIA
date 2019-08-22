<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route()->parameter('grupodocumento');
        $grupoDocumento = 'required|string|max:60|unique:TBL_Grupos_Documentos';

        if ($this->method() == 'PUT') {
            $grupoDocumento = 'required|max:60|' . Rule::unique('TBL_Grupos_Documentos')->ignore($id, 'PK_GRD_Id');
        }

        return [
            'GRD_Nombre' => $grupoDocumento,
            'GRD_Descripcion' => 'required',
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
            'GRD_Nombre.unique' => 'Este grupo ya ha sido registrado.',
            'GRD_Nombre.required' => 'Nombre requerido.',
        ];
    }
}
