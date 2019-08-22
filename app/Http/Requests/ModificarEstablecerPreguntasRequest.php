<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Proceso;
use Illuminate\Foundation\Http\FormRequest;

class ModificarEstablecerPreguntasRequest extends FormRequest
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
            'PK_PGT_Id' => 'required|exists:TBL_Preguntas',
            'PK_BEC_Id' => 'required|exists:TBL_Banco_Encuestas',
        ];
    }

    public function messages()
    {
        return [
            'PK_PGT_Id.required' => 'Pregunta requerida',
            'PK_BEC_Id.required' => 'Encuesta requerida',
            'PK_PGT_Id.exists' => 'La pregunta que selecciono no se encuentra en nuestros registros',
            'PK_BEC_Id.exists' => 'La encuesta que selecciono no se encuentra en nuestros registros',

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
            $procesos = Encuesta::where('FK_ECT_Banco_Encuestas', session()->get('id_encuesta'))
                ->get();
            foreach ($procesos as $proceso) {
                $id_proceso = Proceso::with('fase')->
                where('PK_PCS_Id', $proceso->FK_ECT_Proceso)
                    ->first();
                if ($id_proceso->fase->FSS_Nombre == "captura de datos") {
                    $validator->errors()->add('Error', 'No se puede modificar ya que la encuesta se encuentra relacionada a un proceso en fase de captura de datos');
                }
            }
        });
    }
}