<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\CargoAdministrativo;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\PreguntaEncuesta;

class SolucionEncuestaRequest extends FormRequest
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

            $id_proceso = Proceso::where('PCS_Slug_Procesos', $this->request->get('proceso'))
            ->first()->PK_PCS_Id;
            $id_encuesta = Encuesta::where('FK_ECT_Proceso', '=', $id_proceso)
            ->first();
            $id_cargo = CargoAdministrativo::where('CAA_Slug', '=', $this->request->get('cargo'))
            ->first()->PK_CAA_Id ?? null;
            $id_grupo = GrupoInteres::where('GIT_Slug', $this->request->get('grupo'))
            ->first()->PK_GIT_Id;


            $preguntasR = PreguntaEncuesta::whereHas('preguntas.respuestas', function ($query) {
                return $query->where('FK_PGT_Estado', '1');
            })
                ->with('preguntas.respuestas')
                ->where('FK_PEN_GrupoInteres', '=', $id_grupo)
                ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta->FK_ECT_Banco_Encuestas)
                ->get();
            foreach ($preguntasR as $pregunta) {
                $respuestaUsuario = $this->request->get($pregunta->preguntas->PK_PGT_Id);
                if ($respuestaUsuario == null) {
                    $validator->errors()->add('Error', 'Por favor diligencia el número total de preguntas. Se redirigirá a la página de inicio');
                }
               
            }
        });
    }
}
