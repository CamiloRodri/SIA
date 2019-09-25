<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstitucionRequest extends FormRequest
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
        $id = $this->route()->parameter('institucion');
        return [
            'ITN_Nombre' => 'required|string|max:60' . Rule::unique('TBL_Institucion')->ignore($id, 'PK_ITN_Id'),
            'ITN_Domicilio' => 'required',
            'ITN_Caracter' => 'required',
            'ITN_CodigoSNIES' => 'required',
            'ITN_Norma_Creacion' => 'required',
            'ITN_Estudiantes' => 'required|numeric',
            'FK_ITN_Metodologia' => 'exists:TBL_Metodologias,PK_MTD_Id',
            'ITN_Profesor_Planta' => 'required|string',
            'ITN_Profesor_TCompleto' => 'required|string',
            'ITN_Profesor_TMedio' => 'required|string',
            'ITN_Profesor_Catedra' => 'required|string',
            'ITN_Graduados' => 'required|string',
            'ITN_Mision' => 'required|string',
            'ITN_Vision' => 'required|string',
            'ITN_Descripcion' => 'required',
            'FK_ITN_Estado' => 'exists:TBL_Estados,PK_ESD_Id',
            'ITN_FuenteBoletinMes' => 'required|in:[enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre]',
            'ITN_FuenteBoletinAnio' => 'required|numeric',
            'PK_TRP_Id' => 'numeric'
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
            'ITN_Nombre.unique' => 'esta institución ya ha sido registrada.',
            'ITN_Nombre.required' => 'el campo nombre requerido.',
            'ITN_Domicilio.required' => 'el campo es requerido',
            'ITN_Caracter.required' => 'el campo es requerido',
            'ITN_CodigoSNIES.required' => 'el campo es requerido',
            'ITN_Norma_Creacion.required' => 'el campo es requerido',
            'ITN_Estudiantes.required' => 'el campo es requerido',
            'ITN_Estudiantes' => 'el campo debe ser unb numero',
            'ITN_Profesor_Planta.required' => 'el campo es requerido',
            'ITN_Profesor_TCompleto.required' => 'el campo es requerido',
            'ITN_Profesor_TMedio.required' => 'el campo es requerido',
            'ITN_Profesor_Catedra.required' => 'el campo es requerido',
            'ITN_Graduados.required' => 'el campo es requerido',
            'ITN_Mision.required' => 'el campo es requerido',
            'ITN_Vision.required' => 'el campo es requerido',
            'ITN_Descripcion.required' => 'el campo es requerido',
            'ITN_FuenteBoletinMes.required' => 'el campo es requerido',
            'ITN_FuenteBoletinMes.in' => 'Digite un mes válido para Fuente boletín estadístico',
            'ITN_FuenteBoletinAnio.required' => 'el campo es requerido',
            'FK_ITN_Metodologia.exists' => 'La Metodología no se encuentra en nuestros registros',
            'FK_ITN_Estado.exists' => 'El Estado no se encuentra en nuestros registros'
        ];
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $frenteEstrategico = FrenteEstrategico::select('TRP_TotalPonderacion', 'TRP_CantidadRespuestas')
    //             ->where('PK_TRP_Id', $this->request->get('PK_TRP_Id'))
    //             ->first();
    //         $sumatoria = 0;
    //         for ($i = 1; $i <= $frenteEstrategico->TRP_CantidadRespuestas; $i++) {
    //             $ponderacion = PonderacionRespuesta::select('PRT_Ponderacion')
    //                 ->where('PK_PRT_Id', $this->request->get('Ponderacion_' . $i))
    //                 ->first();
    //             $sumatoria = $sumatoria + $ponderacion->PRT_Ponderacion;
    //         }
    //         if ($sumatoria != $frenteEstrategico->TRP_TotalPonderacion) {
    //             $validator->errors()->add('Seleccione un proceso', 'Las ponderaciones no coinciden!');
    //         }
    //     });
    // }
}
