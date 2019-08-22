<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DependenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $id = $this->route()->parameter('dependencium');
        $dependencia = 'required|string|max:80|unique:TBL_Dependencias';

        if ($this->method() == 'PUT') {
            $dependencia = 'required|max:80|' . Rule::unique('TBL_Dependencias')->ignore($id, 'PK_DPC_Id');
        }

        return [
            'DPC_Nombre' => $dependencia,
        ];
    }

    public function messages()
    {
        return [
            'DPC_Nombre.unique' => 'Esta dependencia ya ha sido registrada',
        ];
    }
}
