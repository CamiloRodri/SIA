<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalificaActividadRequest extends FormRequest
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
        $id = $this->route()->parameter('califica');
        return [
            'CLA_Calificacion' => 'required|numeric',
            'CLA_Observacion' => 'required|max:250'
        ];
    }

    public function messages()
    {
        return [
            'CLA_Calificacion.required' => 'El campo Calificación es requerido',
            'CLA_Calificacion.numeric' => 'El campo Calificación debe ser numérico',
            'CLA_Observacion.required' => 'El campo Observación es requerido'
        ];
    }
}
