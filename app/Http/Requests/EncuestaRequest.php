<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\Proceso;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EncuestaRequest extends FormRequest
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
        $id = $this->route()->parameter('datosEspecifico');
        $datos = 'required|unique:TBL_Encuestas,fk_ect_proceso';

        if ($this->method() == 'PUT') {
            $datos = Rule::unique('TBL_Encuestas', 'fk_ect_proceso')->ignore($id, 'PK_ECT_Id');
        }
        return [
            'ECT_FechaPublicacion' => 'required',
            'ECT_FechaFinalizacion' => 'required',
            'PK_ESD_Id' => 'exists:TBL_Estados',
            'PK_BEC_Id' => 'required|exists:TBL_Banco_Encuestas',
            'PK_PCS_Id' => 'required|exists:TBL_Procesos',
            'PK_PCS_Id' => $datos
        ];
    }

    public function messages()
    {
        return [
            'ECT_FechaPublicacion.required' => 'Fecha de publicacion requerida.',
            'PK_PCS_Id.required' => 'Debe seleccionar un proceso.',
            'PK_BEC_Id.required' => 'Debe seleccionar una encuesta.',
            'ECT_FechaFinalizacion.required' => 'Fecha de finalizacion requerida.',
            'PK_ESD_Id.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'PK_BEC_Id.exists' => 'La encuesta seleccionada no se encuentra en nuestros registros',
            'PK_PCS_Id.unique' => 'Ya existen datos relacionados al proceso seleccionado.',
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
            if (!empty($this->request->get('PK_PCS_Id'))) {
                $proceso = Proceso::with('fase')->
                where('PK_PCS_Id', $this->request->get('PK_PCS_Id'))
                    ->first();
                if ($proceso->fase->FSS_Nombre != "construccion") {
                    $validator->errors()->add('Error', 'El proceso seleccionado no se encuentra en fase de construccion!');
                }
                $caracteristicas = Caracteristica::whereHas('factor', function ($query) use ($proceso) {
                    return $query->where('FK_FCT_Lineamiento', $proceso->FK_PCS_Lineamiento);
                })->get();
                foreach ($caracteristicas as $caracteristica) {
                    $verificar = PreguntaEncuesta::whereHas('preguntas', function ($query) use ($caracteristica) {
                        return $query->where('FK_PGT_Caracteristica', $caracteristica->PK_CRT_Id);
                    })->where('FK_PEN_Banco_Encuestas', $this->request->get('PK_BEC_Id'))->get();
                    if (!$verificar->count()) {
                        $validator->errors()->add('Error', ' La encuesta tiene la siguiente caracteristica faltante ' . $caracteristica->CRT_Nombre);
                    }
                }
            }
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('ECT_FechaPublicacion'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('ECT_FechaFinalizacion'));
            if ($fechaInicio >= $fechaFin) {
                $validator->errors()->add('Error', 'La fecha de publicacion tiene que ser menor que la fecha de finalizacion');
            }
        });
    }
}