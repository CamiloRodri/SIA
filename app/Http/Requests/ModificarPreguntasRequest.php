<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\PonderacionRespuesta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\TipoRespuesta;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Proceso;
use Illuminate\Foundation\Http\FormRequest;

class ModificarPreguntasRequest extends FormRequest
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
            $id = $this->route()->parameter('pregunta');
            $sumatoria = 0;
            foreach ($this->request->get('ponderaciones') as $ponderacion) {
                $valorPonderacion = PonderacionRespuesta::select('PRT_Ponderacion')
                    ->where('PK_PRT_Id', $ponderacion)
                    ->first();
                $sumatoria = $sumatoria + $valorPonderacion->PRT_Ponderacion;
            }
            $tipos = Pregunta::select('FK_PGT_TipoRespuesta')
                ->where('PK_PGT_Id', $id)
                ->first();
            $totalPonderacion = TipoRespuesta::select('TRP_TotalPonderacion')
                ->where('PK_TRP_Id', $tipos->FK_PGT_TipoRespuesta)
                ->first();
            if ($sumatoria != $totalPonderacion->TRP_TotalPonderacion) {
                $validator->errors()->add('Seleccione un proceso', 'Asegurese de seleccionar correctamente las ponderaciones!');
            }

            $preguntas_encuestas = PreguntaEncuesta::where('FK_PEN_Pregunta','=',$id)
            ->orderBy('FK_PEN_Banco_Encuestas')
            ->get();
            foreach($preguntas_encuestas as $pregunta_encuesta)
            {
                $procesos = Encuesta::where('FK_ECT_Banco_Encuestas', $pregunta_encuesta->FK_PEN_Banco_Encuestas)
                ->get();
                foreach ($procesos as $proceso) {
                    $id_proceso = Proceso::with('fase')->
                    where('PK_PCS_Id', $proceso->FK_ECT_Proceso)
                        ->first();
                    if ($id_proceso->fase->FSS_Nombre == "captura de datos") {
                        $validator->errors()->add('Error', 'No se puede modificar ya que la encuesta se encuentra relacionada a un proceso en fase de captura de datos');
                    }
                }
            }
        });
    }
}
