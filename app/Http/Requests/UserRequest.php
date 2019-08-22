<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $password = 'required|min:3';
        $estado = 'required|numeric|exists:TBL_Estados';
        $id = $this->route()->parameter('usuario');
        $roles = 'required';

        if ($this->method() == 'PUT') {
            $password = '';
        }
        return [
            'email' => 'required|email|' . Rule::unique('users')->ignore($id),
            'password' => $password,
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'cedula' => 'required|numeric|max:9999999999|' . Rule::unique('users')->ignore($id),
            'PK_ESD_Id' => $estado,
            'roles' => $roles
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
            'cedula.unique' => 'Esta cedula ya ha sido registrada.',
            'PK_ESD_Id.required' => 'El estado es requerido',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
            'name.required' => 'El campo nombre es requerido.',
            'name.string' => 'El nombre debe ser un nombre valido.',
            'name.max' => 'El nombre debe ser de máximo 50 caracteres.',
            'lastname.required' => 'El campo apellido es requerido.',
            'lastname.string' => 'El apellido debe ser un apellido valido.',
            'lastname.max' => 'El apellido debe ser de máximo 50 caracteres.'

        ];
    }
}
