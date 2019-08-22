<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineamientosRequest extends FormRequest
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
        $id = $this->route()->parameter('lineamiento');
        $archivo = "";
        if ($this->hasFile('archivo')) {
            $archivo = 'file|mimes:xlsx';
        }
        return [
            'LNM_Nombre' => 'required|' . Rule::unique('TBL_Lineamientos')->ignore($id, 'PK_LNM_Id'),
            'LNM_Descripcion' => 'required',
            'archivo' => $archivo
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
            'LNM_Nombre.required' => 'el campo nombre requerido.',
            'LNM_Nombre.unique' => 'Este nombre ya se encuentra en nuestros registros',
            'LNM_Descripcion.required' => 'el campo descripción es requerido.',
        ];
    }
}
