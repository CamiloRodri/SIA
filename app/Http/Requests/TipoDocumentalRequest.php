<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TipoDocumentalRequest extends FormRequest
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
        $id = $this->route()->parameter('tipodocumento');
        $tipoDocumento = 'required|string|max:80|unique:TBL_Tipo_Documentos';

        if ($this->method() == 'PUT') {
            $tipoDocumento = 'required|max:80|' . Rule::unique('TBL_Tipo_Documentos')->ignore($id, 'PK_TDO_Id');
        }

        return [
            'TDO_Nombre' => $tipoDocumento
        ];
    }

    public function messages()
    {
        return [
            'TDO_Nombre.unique' => 'Este tipo de documento ya ha sido registrado',
        ];
    }
}
