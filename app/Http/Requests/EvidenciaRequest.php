<?php

namespace App\Http\Requests;

use App\Models\Autoevaluacion\Evidencia;
use Illuminate\Foundation\Http\FormRequest;

class EvidenciaRequest extends FormRequest
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
        $id = $this->route()->parameter('evidencia');
        $idArchivo = Evidencia::find($id);
        $comprobar = $this->request->get('comprobarArchivo');
        if ($this->hasFile('archivo') && $this->request->get('link') !== null) {
            $link = 'file';
        } elseif ($this->hasFile('archivo')) {
            $link = '';
            $archivo = 'file';

        } elseif ($this->request->get('EVD_Link') !== null) {
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
            'EVD_Nombre' => 'required|max:60|',// . Rule::unique('TBL_Evidencias')->ignore($id, 'PK_EVD_Id'),
            'EVD_Link' => $link,
            'EVD_Descripcion_General' => 'required',
            'archivo' => $archivo
        ];
    }
    public function messages()
    {
        return [
            'EVD_Nombre.required' => 'El campo Nombre es oblogatorio.',
            'EVD_Nombre.max' => 'El campo Nombre tiene máximo 60 caracteres.',
            'archivo.file' => 'El archivo debe ser un archivo valido.',
            'EVD_Link.url' => 'El campo link debe ser un link valido.',
            'EVD_Link.file' => 'Por favor ingrese solo un archivo o un link no ambos.',
            'EVD_Link.required' => 'Por favor ingrese un Link o un archivo.',
        ];
    }
}
