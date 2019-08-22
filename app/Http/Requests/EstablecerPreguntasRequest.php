<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\Proceso;
use Illuminate\Foundation\Http\FormRequest;

class EstablecerPreguntasRequest extends FormRequest
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
            foreach ($this->request->get('gruposInteres') as $grupo => $valor) {
                $verificar = PreguntaEncuesta::where('FK_PEN_Pregunta', $this->request->get('PK_PGT_Id'))
                    ->where('FK_PEN_Banco_Encuestas', $this->request->get('PK_BEC_Id'))
                    ->where('FK_PEN_GrupoInteres', $valor)
                    ->first();
                if ($verificar) {
                    $grupos = GrupoInteres::where('PK_GIT_Id', $valor)->first();
                    $validator->errors()->add('Error', 'Ya existe la pregunta seleccionada para el grupo de interes de ' . $grupos->GIT_Nombre);
                }
            }
            $procesos = Encuesta::where('FK_ECT_Banco_Encuestas', session()->get('id_encuesta'))
                ->get();
            foreach ($procesos as $proceso) {
                $id_proceso = Proceso::with('fase')->
                where('PK_PCS_Id', $proceso->FK_ECT_Proceso)
                    ->first();
                if ($id_proceso->fase->FSS_Nombre == "captura de datos") {
                    $validator->errors()->add('Error', 'No se puede agregar la pregunta ya que la encuesta se encuentra relacionada a un proceso en fase de captura de datos!');
                }
            }
        });
    }
}

