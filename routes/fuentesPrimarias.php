<?php
/**
 * Fuentes primarias
 */
//datos generales encuestas
Route::resource('datosEncuestas', 'DatosEncuestasController', ['as' => 'fuentesP'])->except(['show']);
Route::get('datosEncuestas/data', array('as' => 'fuentesP.datosEncuestas.data', 'uses' => 'DatosEncuestasController@data'));

//Banco de Encuestas
Route::resource('bancoEncuestas', 'BancoEncuestasController', ['as' => 'fuentesP']);
Route::get('bancoEncuestas/data/data', array('as' => 'fuentesP.bancoEncuestas.data', 'uses' => 'BancoEncuestasController@data'));

//construccion de encuestas
Route::resource('datosEspecificos', 'DatosEspecificosController', ['as' => 'fuentesP'])->except(['show']);
Route::get('datosEspecificos/data', array('as' => 'fuentesP.datosEspecificos.data', 'uses' => 'DatosEspecificosController@data'));

//establecer preguntas
Route::resource('establecerPreguntas', 'EstablecerPreguntasController', ['as' => 'fuentesP'])->except(['show']);
Route::get('establecerPreguntas/{id}', array('as' => 'fuentesP.establecerPreguntas.datos', 'uses' => 'EstablecerPreguntasController@index'));
Route::get('establecerPreguntas/data/data', array('as' => 'fuentesP.establecerPreguntas.data', 'uses' => 'EstablecerPreguntasController@data'));

//Gestionar Tipo de respuesta
Route::resource('tipoRespuesta', 'TipoRespuestaController', ['as' => 'fuentesP']);
Route::get('tipoRespuesta/data/data', array('as' => 'fuentesP.tipoRespuesta.data', 'uses' => 'TipoRespuestaController@data'));

//Gestionar Ponderaciones
Route::resource('ponderacionRespuesta', 'PonderacionRespuestasController', ['as' => 'fuentesP']);
Route::get('mostrarPonderaciones/{id}', array('as' => 'fuentesP.mostrarPonderaciones.datos', 'uses' => 'PonderacionRespuestasController@mostrarPonderaciones'));

//preguntas
Route::resource('preguntas', 'PreguntasController', ['as' => 'fuentesP']);
Route::get('preguntas/data/data', array('as' => 'fuentesP.preguntas.data', 'uses' => 'PreguntasController@data'));

//resultados
Route::resource('resultados', 'ResultadosController', ['as' => 'fuentesP']);
Route::get('resultados/data/data', array('as' => 'fuentesP.resultados.data', 'uses' => 'ResultadosController@data'));

//Importar preguntas
Route::resource('Importarpreguntas', 'ImportarPreguntasController', ['as' => 'fuentesP']);

//informes de Encuestas
Route::get('informes_encuestas', array(
    'as' => 'primarias.informe_encuestas',
    'uses' => 'ReportesEncuestasController@index'
));

Route::get('informes_encuestas/datos', array(
    'as' => 'primarias.informe_encuestas.datos',
    'uses' => 'ReportesEncuestasController@obtenerDatos'
));

//filtros informes encuestas
Route::post('informes_encuestas/filtrar', array(
    'as' => 'primarias.informe_encuestas.filtrar',
    'uses' => 'ReportesEncuestasController@filtro'
));

Route::post('informes_encuestas/filtrar_factores', array(
    'as' => 'primarias.informe_encuestas.filtrar_factores',
    'uses' => 'ReportesEncuestasController@filtro_factores'
));

Route::get(
    'grupos/preguntas/{id}',
    array('as' => 'primarias.grupos.preguntas',
        'uses' => 'ReportesEncuestasController@obtenerPreguntas')
);

//Reportes pdf documentos de autoevaluacion
Route::post('informes_encuestas/descargar', array(
        'as' => 'encuestas.informe_encuesta.descargar',
        'uses' => 'ReportesEncuestasController@pdf_documento_encuestas'
    )
);
