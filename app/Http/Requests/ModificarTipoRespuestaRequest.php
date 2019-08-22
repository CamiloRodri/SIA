<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\PonderacionRespuesta;
use Illuminate\Foundation\Http\FormRequest;

class ModificarTipoRespuestaRequest extends FormRequest
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
            'TRP_TotalPonderacion' => 'required',
            'TRP_Descripcion' => 'required',
            'PK_ESD_Id' => 'required|exists:TBL_Estados'
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
            'TRP_TotalPonderacion.required' => 'El total de ponderacion es requerido',
            'TRP_Descripcion.required' => 'La descripción es requerida',
            'PK_ESD_Id.required' => 'Debe seleccionar un estado.',
            'PK_ESD_Id.exists' => 'El estado que seleccionó no existe en nuestros registros.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route()->parameter('tipoRespuestum');
            $sumatoria = 0;
            $valorOne = 0;
            $valorDos = 0;
            $bandera = 0;
            foreach (PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)->get() as $ponderacion) {
                $sumatoria = $sumatoria + $this->request->get($ponderacion->PK_PRT_Id);
            }
            if ($sumatoria != $this->request->get('TRP_TotalPonderacion')) {
                $validator->errors()->add('Seleccione un proceso', 'La suma de ponderaciones no corresponde con el total de ponderacion digitado!');
            }
            $i = 1;
            foreach (PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)->get() as $ponderacion) {
                $sumatoria = $sumatoria + $this->request->get($ponderacion->PK_PRT_Id);
                if ($i == 1) {
                    $valorOne = $this->request->get($ponderacion->PK_PRT_Id);
                }
                if ($i == 2) {
                    if ($valorOne <= $this->request->get($ponderacion->PK_PRT_Id)) {
                        $bandera = 1;
                    }
                    $valorOne = $this->request->get($ponderacion->PK_PRT_Id);
                }
                $i = 2;
            }
            if ($bandera == 1) {
                $validator->errors()->add('Error', 'Las ponderaciones deben ir en orden de mayor a menor. Por favor verifique');
            }
        });
    }
}

