<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $password = 'required|min:3';
        $estado = 'required';
        $id = $this->route()->parameter('usuario');

        if ($this->method() == 'PUT') {
            $password = '';
        }
        return [
            'password' => $password,
            'estado_pass' => $estado,

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
            'email' => 'El email es requerido',
            'password' => 'La contraseña es requerida',

        ];
    }
}
