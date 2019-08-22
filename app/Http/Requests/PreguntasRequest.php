<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\TipoRespuesta;
use Illuminate\Foundation\Http\FormRequest;

class PreguntasRequest extends FormRequest
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
            'PGT_Texto' => 'required|string',
            'PK_ESD_Id' => 'required|exists:TBL_Estados',
            'PK_TRP_Id' => 'required|exists:TBL_Tipo_Respuestas',
            'PK_CRT_Id' => 'required|exists:TBL_Caracteristicas',

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
            'PGT_Texto.required' => 'Debe digitar una respuesta',
            'PK_ESD_Id.required' => 'Debe seleccionar un estado.',
            'PK_ESD_Id.exists' => 'El estado que selecciona no existe en nuestros registros.',
            'PK_TRP_Id.required' => 'Debe seleccionar un tipo de respuesta.',
            'PK_TRP_Id.exists' => 'El tipo de respuesta que selecciona no existe en nuestros registros.',
            'PK_CRT_Id.required' => 'Debe seleccionar una caracteristica.',
            'PK_CRT_Id.exists' => 'La caracteristica que selecciona no existe en nuestros registros.'

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
            $tipoRespuesta = TipoRespuesta::select('TRP_TotalPonderacion', 'TRP_CantidadRespuestas')
                ->where('PK_TRP_Id', $this->request->get('PK_TRP_Id'))
                ->first();
            $sumatoria = 0;
            for ($i = 1; $i <= $tipoRespuesta->TRP_CantidadRespuestas; $i++) {
                $ponderacion = PonderacionRespuesta::select('PRT_Ponderacion')
                    ->where('PK_PRT_Id', $this->request->get('Ponderacion_' . $i))
                    ->first();
                $sumatoria = $sumatoria + $ponderacion->PRT_Ponderacion;
            }
            if ($sumatoria != $tipoRespuesta->TRP_TotalPonderacion) {
                $validator->errors()->add('Seleccione un proceso', 'Las ponderaciones no coinciden!');
            }
        });
    }
}
