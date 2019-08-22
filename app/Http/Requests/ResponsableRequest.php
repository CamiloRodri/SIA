<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Autoevaluacion\Responsable;

class ResponsableRequest extends FormRequest
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
            'id' => 'required|exists:users'
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
            'id.required' => 'Debe seleccionar un responsable.',
            'id.exists' => 'El usuario que selecciona no existe en nuestros registros.',
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
            $responsable = Responsable::where('FK_RPS_Responsable','=',$this->request->get('id'))
            ->where('FK_RPS_Proceso','=',session()->get('id_proceso')??null)
            ->first();
            if ($responsable) {
                $validator->errors()->add('Error', 'El responsable ya existe!');
            }
        });
    }
}