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
            'PAC_Periodicidad' => 'required|max:20',
            'PAC_Adscrito' => 'required|max:50',
            'PAC_Area_Conocimiento' => 'required|max:100',
            'PAC_Nucleo' => 'required|max:100',
            'PAC_Area_Formacion' => 'required|max:100',
            'PAC_Estudiantes' => 'required|numeric',
            'PAC_Egresados' => 'required|numeric',
            'PAC_Valor_Matricula' => 'required|numeric|min:0',
            'PAC_Docentes_Actual' => 'required|numeric|min:3',
            'PAC_Directivos_Academicos' => 'required|numeric|min:1',
            'PAC_Administrativos' => 'required|numeric|min:1',
            'PAC_Egresados_Cinco' => 'required|numeric|min:1',
            'PAC_Empresarios' => 'required|numeric|min:1',

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
            'PAC_Nivel_Formacion.required' => 'Nive de formacion requerido.',
            'PAC_Nivel_Formacion.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Titutlo_Otorga.required' => 'Titulo que ortorga es requerido.',
            'PAC_Titutlo_Otorga.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Situacion_Programa.required' => 'Situacón de programa requerido.',
            'PAC_Situacion_Programa.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Anio_Inicio_Actividades.required' => 'Año de iniciacion de actividades requerido.',
            'PAC_Anio_Inicio_Actividades.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Descripcion.required' => 'Descripción requerido.',
            'PAC_Descripcion.max' => 'El campo nombre debe tener máximo 200 caracteres.',
            'PAC_Anio_Inicio_Programa.required' => 'Año de inicio del programa requerida.',
            'PAC_Anio_Inicio_Programa.numeric' => 'Campo debe ser numérico.',
            'PAC_Lugar_Funcionamiento.required' => 'Lugar de funcionamiento requerido.',
            'PAC_Lugar_Funcionamiento.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Norma_Interna.required' => 'Norma interna requerida.',
            'PAC_Norma_Interna.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Resolucion_Registro.required' => 'resolución de registro requerido.',
            'PAC_Resolucion_Registro.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Codigo_SNIES.required' => 'Código SNIES requerido.',
            'PAC_Codigo_SNIES.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Numero_Creditos.required' => 'Número de créditos requerido.',
            'PAC_Numero_Creditos.numeric' => 'Campo debe ser numérico.',
            'PAC_Duracion.required' => 'Duración requerido.',
            'PAC_Duracion.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Jornada.required' => 'Jornada requerida.',
            'PAC_Jornada.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Duracion_Semestre.required' => 'Duración del semestre requerido.',
            'PAC_Duracion_Semestre.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Periodicidad.required' => 'Campo Periodicidad de la admisión',
            'PAC_Periodicidad.max' => 'Campo Periodicidad debe terner máximo 20 caracteres',
            'PAC_Adscrito.required' => 'Campo Adscrito requerido',
            'PAC_Adscrito.max' => 'Campo Adscrito debe terner máximo 50 caracteres',
            'PAC_Area_Conocimiento.required' => 'Campo Área del conocimiento requerido',
            'PAC_Area_Conocimiento.max' => 'Campo Área de conocimiento debe terner máximo 100 caracteres',
            'PAC_Nucleo.required' => 'Campo Nucleo básico del conocimiento requerdio',
            'PAC_Nucleo.max' => 'Campo Nucleo básico del conocimiento debe terner máximo 100 caracteres',
            'PAC_Area_Formacion.required' => 'Campo Área de formación requerido',
            'PAC_Area_Formacion.max' => 'Campo Áre de formación debe terner máximo 100 caracteres',
            'PAC_Estudiantes.required' => 'Campo Número actual de estudiantes requerido',
            'PAC_Estudiantes.number' => 'Campo Número actual de estudiantes debe ser numérico',
            'PAC_Egresados.required' => 'Campo Número de egresados requerido',
            'PAC_Egresados.number' => 'Campo Número de egresados debe ser numérico',
            'PAC_Valor_Matricula.required' => 'Campo Valor de la matricula requerido',
            'PAC_Valor_Matricula.number' => 'Campo Valor de la matricula debe ser numérico',
            'PAC_Valor_Matricula.min' => 'Campo Valor de la matricula debe mínimo 0',
            'PAC_Docentes_Actual.required' => 'Campo Valor de la matricula requerido',
            'PAC_Docentes_Actual.number' => 'Campo Valor de la matricula debe ser numérico',
            'PAC_Docentes_Actual.min' => 'Campo Valor de la matricula debe mínimo 3',
            'PAC_Directivos_Academicos.required' => 'Campo Valor de la Directivo Académico requerido',
            'PAC_Directivos_Academicos.number' => 'Campo Valor de la Directivo Académico debe ser numérico',
            'PAC_Directivos_Academicos.min' => 'Campo Valor de la Directivo Académico debe mínimo 0',
            'PAC_Administrativos.required' => 'Campo Valor de administrativos requerido',
            'PAC_Administrativos.number' => 'Campo Valor de administrativos debe ser numérico',
            'PAC_Administrativos.min' => 'Campo Valor de administrativos debe mínimo 1',
            'PAC_Egresados_Cinco.required' => 'Campo Valor de egresados requerido',
            'PAC_Egresados_Cinco.number' => 'Campo Valor de egresados debe ser numérico',
            'PAC_Egresados_Cinco.min' => 'Campo Valor de egresados debe mínimo 1',
            'PAC_Empresarios.required' => 'Campo Valor de empresarios requerido',
            'PAC_Empresarios.number' => 'Campo Valor de empresarios debe ser numérico',
            'PAC_Empresarios.min' => 'Campo Valor de empresarios debe mínimo 1',

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
