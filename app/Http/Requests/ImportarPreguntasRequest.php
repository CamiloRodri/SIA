<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportarPreguntasRequest extends FormRequest
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
        $archivo = "";
        if ($this->hasFile('archivo')) {
            $archivo = 'file|mimes:xlsx';
        }
        return [
            'archivo' => $archivo
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
            $id = session()->get('id_proceso');
            if ($id == null) {
                $validator->errors()->add('Seleccione un proceso', 'Por favor seleccione un proceso!');
            }
        });
    }
}