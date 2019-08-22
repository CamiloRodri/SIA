<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\Responsable;
use Illuminate\Support\Facades\Auth;


class ModificarActividadesRequest extends FormRequest
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
            $id = $this->route()->parameter('actividades_mejoramiento');
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('ACM_Fecha_Inicio'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('ACM_Fecha_Fin'));
            if ($fechaInicio >= $fechaFin) {
                $validator->errors()->add('Error', 'La fecha de inicio tiene que ser menor que la fecha de finalizacion');
            }
            $actividad = ActividadesMejoramiento::find($id);
            $responsable = Responsable::where('PK_RPS_Id','=',$actividad->FK_ACM_Responsable)
            ->first();
            $id_usuario = Auth::user()->id;
            if(!Auth::user()->hasRole('SUPERADMIN') || !Auth::user()->hasRole('SUPERADMIN'))
            {
                if($id_usuario != $responsable->FK_RPS_Responsable )
                {
                    $validator->errors()->add('Error', 'Usted no es responsable de esta actividad de mejoramiento');
                }
            } 
        });
    }
}