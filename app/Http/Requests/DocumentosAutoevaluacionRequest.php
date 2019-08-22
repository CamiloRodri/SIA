<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\Proceso;
use Illuminate\Foundation\Http\FormRequest;

class DocumentosAutoevaluacionRequest extends FormRequest
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
        $archivo = "required";
        $link = "required";
        $id = $this->route()->parameter('documentos_autoevaluacion');
        $idArchivo = DocumentoAutoevaluacion::find($id);
        $comprobar = $this->request->get('comprobarArchivo');
        if ($this->hasFile('archivo') && $this->request->get('DOA_Link') !== null) {
            $link = 'file';
        } elseif ($this->hasFile('archivo')) {
            $link = '';
            $archivo = 'file';

        } elseif ($this->request->get('DOA_Link') !== null) {
            $link = 'url';
            $archivo = '';
            if ($this->method() == 'PUT' && ($comprobar == 'true' && isset($idArchivo->FK_DOA_Archivo))) {
                $link = 'file';
            }
        } elseif ($this->method() == 'PUT' && ($comprobar == 'true' && isset($idArchivo->FK_DOA_Archivo))) {
            $archivo = "";
            $link = "";
        }

        return [
            'PK_FCT_Id' => 'exists:TBL_Factores',
            'PK_CRT_Id' => 'exists:TBL_Caracteristicas',
            'PK_IDO_Id' => 'exists:TBL_Indicadores_Documentales',
            'PK_DPC_Id' => 'exists:TBL_Dependencias',
            'PK_TDO_Id' => 'exists:TBL_Tipo_Documentos',
            'DOA_Numero' => 'numeric',
            'DOA_Anio' => 'numeric',
            'DOA_Link' => $link,
            'archivo' => $archivo
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
            'PK_FCT_Id.exists' => 'El factor que selecciono no existe en nuestros registros.',
            'PK_CRT_Id.exists' => 'La característica que selecciono no existe en nuestros registros.',
            'PK_IDO_Id.exists' => 'El Indicador que selecciono no existe en nuestros registros.',
            'PK_DPC_Id.exists' => 'La dependencia que selecciono no existe en nuestros registros.',
            'PK_TDO_Id.exists' => 'El tipo de documento que selecciono no existe en nuestros registros.',
            'DOA_Numero.numeric' => 'El campo numero debe ser un numero.',
            'DOA_Anio.numeric' => 'El campo año debe ser un año valido.',
            'archivo.file' => 'El archivo debe ser un archivo valido.',
            'DOA_Link.url' => 'El campo link debe ser un link valido.',
            'DOA_Link.file' => 'Por favor ingrese solo un archivo o un link no ambos.',
            'DOA_Link.required' => 'Por favor ingrese un Link o un archivo.',

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
            if ($this->method() == 'POST') {
                $proceso = Proceso::find(session()->get('id_proceso'));
                if ($proceso->FK_PCS_Fase != 4) {
                    $validator->errors()->add('Error', 'El proceso se debe encontrar en fase de captura de datos para poder guardar documentos.');

                }
            }

            if ($this->method() == 'PUT') {
                $id = $this->route()->parameter('documentos_autoevaluacion');
                $documento = DocumentoAutoevaluacion::findOrFail($id);
                $proceso = Proceso::find($documento->FK_DOA_Proceso);

                if ($proceso->FK_PCS_Fase != 4 && $proceso->FK_PCS_Fase != 5) {
                    $validator->errors()->add('Error', 'El proceso se debe encontrar en fase de captura de datos o de consolidación para poder modificar la información de los documentos.');
                }
            }

            if ($this->method() == 'DELETE') {
                $proceso = Proceso::find(session()->get('id_proceso'));
                if ($proceso->FK_PCS_Fase != 4) {
                    $validator->errors()->add('Error', 'El proceso se debe encontrar en fase de captura de datos para poder eliminar documentos.');
                }

            }
        });
    }
}
