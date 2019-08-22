<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\DocumentoInstitucional;
use Illuminate\Foundation\Http\FormRequest;

class DocumentoInstitucionalRequest extends FormRequest
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
        $id = $this->route()->parameter('documentoinstitucional');
        $idArchivo = DocumentoInstitucional::find($id);
        $comprobar = $this->request->get('comprobarArchivo');
        if ($this->hasFile('archivo') && $this->request->get('link') !== null) {
            $link = 'file';
        } elseif ($this->hasFile('archivo')) {
            $link = '';
            $archivo = 'file';

        } elseif ($this->request->get('link') !== null) {
            $link = 'url';
            $archivo = '';
            if ($this->method() == 'PUT' && ($comprobar == 'true' && isset($idArchivo->FK_DOI_Archivo))) {
                $link = 'file';
            }
        } elseif ($this->method() == 'PUT' && ($comprobar == 'true' && isset($idArchivo->FK_DOI_Archivo))) {
            $archivo = "";
            $link = "";
        }
        return [
            'FK_DOI_GrupoDocumento' => 'required',
            'PK_GRD_Id' => 'exists:TBL_Grupos_Documentos',
            'link' => $link,
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
            'FK_DOI_GrupoDocumento.required' => 'Debe seleccionar un grupo de documentos',
            'PK_GRD_Id.exists' => 'El grupo de documentos que selecciono no existe en nuestros registros.',
            'archivo.file' => 'El archivo debe ser un archivo valido.',
            'link.url' => 'El campo link debe ser un link valido.',
            'link.file' => 'Por favor ingrese solo un archivo o un link no ambos.',
            'link.required' => 'Por favor ingrese un Link o un archivo.',

        ];
    }
}