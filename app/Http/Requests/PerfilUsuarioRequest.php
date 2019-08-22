<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class PerfilUsuarioRequest extends FormRequest
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
            'email' => 'required|email|' . Rule::unique('users')->ignore(Auth::id()),
            'password' => 'confirmed',
            'password_confirmation' => 'sometimes|required_with:password',
            'lastname' => 'required|string|max:50',
            'cedula' => 'required|numeric|max:9999999999|' . Rule::unique('users')->ignore(Auth::id()),
            'PK_ESD_Id' => 'sometimes|numeric|exists:TBL_Estados',
            'roles' => 'sometimes'
        ];

    }
}
