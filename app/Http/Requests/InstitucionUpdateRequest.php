<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionUpdateRequest extends FormRequest
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
            'ITN_Nombre' => 'required|max:60|',
            'ITN_Domicilio' => 'required',
            'ITN_Caracter' => 'required',
            'ITN_CodigoSNIES' => 'required',
            'ITN_Norma_Creacion' => 'required',
            'ITN_Estudiantes' => 'required|numeric',
            'FK_ITN_Metodologia' => 'exists:TBL_Metodologias,PK_MTD_Id',
            'ITN_Profesor_Planta' => 'required|numeric',
            'ITN_Profesor_TCompleto' => 'required|numeric',
            'ITN_Profesor_TMedio' => 'required|numeric',
            'ITN_Profesor_Catedra' => 'required|numeric',
            'ITN_Graduados' => 'required|numeric',
            'ITN_Mision' => 'required|string|max:800',
            'ITN_Vision' => 'required|string|max:800',
            'ITN_Descripcion' => 'required',
            'FK_ITN_Estado' => 'exists:TBL_Estados,PK_ESD_Id',
            'ITN_FuenteBoletinMes' => 'required|in:[
                enero,enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre,
                Enero,Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre]',
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
            'ITN_Nombre.unique' => 'Esta institución ya ha sido registrada.',
            'ITN_Nombre.required' => 'El campo nombre requerido.',
            'ITN_Domicilio.required' => 'El campo es requerido',
            'ITN_Caracter.required' => 'El campo es requerido',
            'ITN_CodigoSNIES.required' => 'El campo es requerido',
            'ITN_Norma_Creacion.required' => 'El campo es requerido',
            'ITN_Estudiantes.required' => 'El campo es requerido',
            'ITN_Estudiantes' => 'El campo debe ser numérico',
            'ITN_Profesor_Planta.required' => 'El campo es requerido',
            'ITN_Profesor_Planta.numeric' => 'El campo Planta debe ser numérico',
            'ITN_Profesor_TCompleto.required' => 'El campo es requerido',
            'ITN_Profesor_TCompleto.numeric' => 'El campo Tiempo Completo debe ser numérico',
            'ITN_Profesor_TMedio.required' => 'El campo es requerido',
            'ITN_Profesor_TMedio.numeric' => 'El Tiempo Medio debe ser numérico',
            'ITN_Profesor_Catedra.required' => 'El campo Catedra es requerido',
            'ITN_Profesor_Catedra.numeric' => 'El campo Catedra debe ser numérico',
            'ITN_Graduados.required' => 'El campo es requerido',
            'ITN_Mision.required' => 'El campo es requerido',
            'ITN_Vision.required' => 'El campo es requerido',
            'ITN_Descripcion.required' => 'El campo es requerido',
            'ITN_FuenteBoletinMes.required' => 'El campo es requerido',
            'ITN_FuenteBoletinMes.in' => 'Digite un mes válido para Fuente boletín estadístico',
            'ITN_FuenteBoletinAnio.required' => 'El campo es requerido',
            'FK_ITN_Metodologia.exists' => 'La Metodología no se encuentra en nuestros registros',
            'FK_ITN_Estado.exists' => 'El Estado no se encuentra en nuestros registros'
        ];
    }
}
