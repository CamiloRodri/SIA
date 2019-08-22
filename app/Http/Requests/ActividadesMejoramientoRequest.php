<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ActividadesMejoramientoRequest extends FormRequest
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
            'ACM_Nombre' => 'required',
            'ACM_Descripcion' => 'required',
            'ACM_Fecha_Inicio' => 'required',
            'ACM_Fecha_Fin' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ACM_Nombre.required' => 'Nombre requerido',
            'ACM_Descripcion.required' => 'Descripcion requerida',
            'ACM_Fecha_Inicio.required' => 'Fecha de inicio requerida',
            'ACM_Fecha_Fin.required' => 'Fecha de finalizacion requerida',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('ACM_Fecha_Inicio'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('ACM_Fecha_Fin'));
            if ($fechaInicio >= $fechaFin) {
                $validator->errors()->add('Error', 'La fecha de inicio tiene que ser menor que la fecha de finalizacion');
            }
        });
    }
}
