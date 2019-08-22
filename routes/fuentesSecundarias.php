<?php
/**
 * Fuentes Secundarias
 */

use Illuminate\Http\Request;
use App\Models\Autoevaluacion\Archivo;

//Rutas para especificar las dependencias a las que pertenece cada documento
Route::resource('dependencia', 'DependenciaController', ['as' => 'documental'])->except([
    'show', 'edit'
]);;
Route::get(
    'dependencia/data',
    array('as' => 'documental.dependencia.data', 'uses' => 'DependenciaController@data')
);

//Rutas para organizar el grupo de documentos urilizados por los documentos institucionales
Route::resource('grupodocumentos', 'DocumentGroupController', ['as' => 'documental'])->except([
    'show', 'edit'
]);;
Route::get(
    'grupodocumentos/data',
    array('as' => 'documental.grupodocumentos.data', 'uses' => 'DocumentGroupController@data')
);

//Rutaspara CRUD de tipos de documentos
Route::resource('tipodocumento', 'tipoDocumentoController', ['as' => 'documental'])->except([
    'show', 'edit'
]);
Route::get(
    'fuentes/tipodocumento/data',
    array('as' => 'documental.tipodocumento.data', 'uses' => 'tipoDocumentoController@data')
);

//Rutas CRUD documentos institucionales
Route::resource('documentoinstitucional', 'DocumentoInstitucionalController', ['as' => 'documental'])->except([
    'show'
]);
Route::get(
    'documentoinstitucional/data',
    array('as' => 'documental.documentoinstitucional.data', 'uses' => 'DocumentoInstitucionalController@data')
);

//Rutas CRUD Indicadores documentales
Route::resource('indicadores_documentales', 'IndicadorDocumentalController', ['as' => 'documental']);
Route::get(
    'indicadores_documentales/data/data',
    array('as' => 'documental.indicadores_documentales.data', 'uses' => 'IndicadorDocumentalController@data')
);

//Rutas para CRUD documentos autoevaluacion
Route::resource('documentos_autoevaluacion', 'DocumentoAutoevaluacionController', ['as' => 'documental']);
Route::get(
    'documentos_autoevaluacion/evaluar/{id_documento}',
    array('as' => 'documental.documentos_autoevaluacion.evaluar', 'uses' => 'DocumentoAutoevaluacionController@evaluar')
);
Route::post(
    'documentos_autoevaluacion/evaluar/{id_documento}',
    array('as' => 'documental.documentos_autoevaluacion.evaluar.post', 'uses' => 'DocumentoAutoevaluacionController@evaluarFormulario')
);
Route::get(
    'documentos_autoevaluacion/data/data',
    array('as' => 'documental.documentos_autoevaluacion.data', 'uses' => 'DocumentoAutoevaluacionController@data')
);
Route::get(
    'documentos_autoevaluacion/caracteristicas/{id}',
    array('as' => 'documental.documentos_autoevaluacion.caracteristicas',
        'uses' => 'DocumentoAutoevaluacionController@obtenerCaracteristicas')
);

//Rutas reportes documentales

Route::get('informes_documentales', array(
    'as' => 'documental.informe_documental',
    'uses' => 'ReporteController@index'
));

Route::get('informes_documentales/datos', array(
    'as' => 'documental.informe_documental.datos',
    'uses' => 'ReporteController@obtenerDatos'
));

Route::post('informes_documentales/filtrar', array(
    'as' => 'documental.informe_documental.filtrar',
    'uses' => 'ReporteController@filtro'
));

Route::get('informes_documentales/institucional', array(
    'as' => 'documental.informe_documental.institucional',
    'uses' => 'ReporteController@reportes'
));
Route::get('informes_documentales/data', array(
    'as' => 'documental.informe_documental.data',
    'uses' => 'ReporteController@obtenerDatosInst'
));

//Reportes pdf documentos de autoevaluacion
Route::post('informes_documentales/descargar', array(
        'as' => 'documental.informe_documental.descargar',
        'uses' => 'ReporteController@pdf_documento_autoevaluacion'
    )
);
//Reportes pdf documentos de autoevaluacion
Route::post('informes_institucionales/descargar', array(
    'as' => 'documental.informe_institucionales.descargar',
    'uses' => 'ReporteController@pdf_documentos_institucionales'
));

Route::get('descargar', function (Request $request) {
    $archivo = substr($request->query('archivo'), 9);
    
    $nombre = Archivo::where('ruta', '=', $request->query('archivo'))
        ->get();
    $nombreArchivo = $nombre[0]->ACV_Nombre . '.' . $nombre[0]->ACV_Extension;
    return response()->download(storage_path('app/public/' . $archivo), $nombreArchivo);
})->name('descargar');

