<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\ProgramaAcademico;
use Illuminate\Foundation\Http\FormRequest;

class ProgramasAcademicosRequest extends FormRequest
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
            'PAC_Nombre' => 'required|max:50',
            'PAC_Nivel_Formacion' => 'required|max:50',
            'PAC_Titutlo_Otorga' => 'required|max:50',
            'PAC_Situacion_Programa' => 'required|max:50',
            'PAC_Anio_Inicio_Actividades' => 'required|max:50',
            'PAC_Descripcion' => 'required|max:200',
            'PAC_Anio_Inicio_Programa' => 'required|numeric',
            'PAC_Lugar_Funcionamiento' => 'required|max:50',
            'PAC_Norma_Interna' => 'required|max:50',
            'PAC_Resolucion_Registro' => 'required|max:50',
            'PAC_Codigo_SNIES' => 'required|max:50',
            'PAC_Numero_Creditos' => 'required|numeric',
            'PAC_Duracion' => 'required|max:50',
            'PAC_Jornada' => 'required|max:50',
            'PAC_Duracion_Semestre' => 'required|max:50',

            'PK_ESD_Id' => 'exists:TBL_Estados|numeric',
            'PK_SDS_Id' => 'exists:TBL_Sedes|numeric',
            'PK_FCD_Id' => 'exists:TBL_Facultades|numeric'
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
            'PAC_Nombre.required' => 'Nombre requerido.',
            'PAC_Nombre.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Nivel_Formacion' => 'Nive de formacion requerido.',
            'PAC_Nivel_Formacion' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Titutlo_Otorga' => 'Titulo que ortorga es requerido.',
            'PAC_Titutlo_Otorga' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Situacion_Programa' => 'Situacón de programa requerido.',
            'PAC_Situacion_Programa' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Anio_Inicio_Actividades' => 'Año de iniciacion de actividades requerido.',
            'PAC_Anio_Inicio_Actividades' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Descripcion' => 'Descripción requerido.',
            'PAC_Descripcion' => 'El campo nombre debe tener máximo 200 caracteres.',
            'PAC_Anio_Inicio_Programa' => 'Año de inicio del programa requerida.',
            'PAC_Anio_Inicio_Programa' => 'Campo debe ser numérico.',
            'PAC_Lugar_Funcionamiento' => 'Lugar de funcionamiento requerido.',
            'PAC_Lugar_Funcionamiento' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Norma_Interna' => 'Norma interna requerida.',
            'PAC_Norma_Interna' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Resolucion_Registro' => 'resolución de registro requerido.',
            'PAC_Resolucion_Registro' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Codigo_SNIES' => 'Código SNIES requerido.',
            'PAC_Codigo_SNIES' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Numero_Creditos' => 'Número de créditos requerido.',
            'PAC_Numero_Creditos' => 'Campo debe ser numérico.',
            'PAC_Duracion' => 'Duración requerido.',
            'PAC_Duracion' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Jornada' => 'Jornada requerida.',
            'PAC_Jornada' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Duracion_Semestre' => 'Duración del semestre requerido.',
            'PAC_Duracion_Semestre' => 'El campo nombre debe tener máximo 50 caracteres.',

            'PK_ESD_Id.required' => 'El estado es requerido.',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
            'PK_SDS_Id.required' => 'La sede es requerida.',
            'PK_SDS_Id.numeric' => 'Sede invalida.',
            'PK_SDS_Id.exists' => 'Esta sede no existe en nuestros registros.',
            'PK_FCD_Id.required' => 'La facultad es requerida.',
            'PK_FCD_Id.numeric' => 'Facultad invalida.',
            'PK_FCD_Id.exists' => 'Esta facultad no existe en nuestros registros.',
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
            $id = $this->route()->parameter('programas_academico');

            $programas = ProgramaAcademico::where('FK_PAC_Sede', '=', $this->request->get('PK_SDS_Id'))
                ->where('PAC_Nombre', '=', $this->request->get('PAC_Nombre'))
                ->where('PK_PAC_Id', '!=', $id)
                ->get();

            if ($programas->count()) {
                $validator->errors()->add('Error', 'En la sede seleccionada ya se encuentra este programa.');
            }
        });
    }
}
