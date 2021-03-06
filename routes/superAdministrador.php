<?php
/**
 * Super administrador
 */

//Home
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));
//Rutas necesarias para selecionar proceso
Route::get('mostrar_procesos', array('as' => 'admin.mostrar_procesos', 'uses' => 'pageController@mostrarProcesos'));
Route::post('seleccionar_proceso', array('as' => 'admin.mostrar_procesos.seleccionar_proceso', 'uses' => 'pageController@seleccionarProceso'));

//Usuarios
Route::resource('usuarios', 'UserController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'UserController@data'));
Route::get('usuario/perfil', array('as' => 'admin.usuario.perfil', 'uses' => 'UserController@perfil'));
Route::post('usuario/perfil', array('as' => 'admin.usuario.modificar_perfil',
    'uses' => 'UserController@modificarPerfil'));

//Roles
Route::resource('roles', 'RolController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('roles/data', array('as' => 'admin.roles.data', 'uses' => 'RolController@data'));

//Permisos
Route::resource('permisos', 'PermisosController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('permisos/data', array('as' => 'admin.permisos.data', 'uses' => 'PermisosController@data'));

//Lineamientos
Route::resource('lineamientos', 'LineamientoController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('lineamientos/data/data', array('as' => 'admin.lineamientos.data', 'uses' => 'LineamientoController@data'));

//Factores
Route::resource('factores', 'FactorController', ['as' => 'admin']);
Route::get('factores/data/data', array('as' => 'admin.factores.data', 'uses' => 'FactorController@data'));

//Institución
Route::resource('instituciones', 'InstitucionController', ['as' => 'admin']);
Route::get('instituciones/data/data', array('as' => 'admin.instituciones.data', 'uses' => 'InstitucionController@data'));

//Frente Estrategico
Route::resource('institucion/frente_estrategico',
    'FrenteEstrategicoController',
    ['as' => 'admin']);
Route::get('frente_estrategico/data/data', array('as' => 'admin.frente_estrategico.data',
    'uses' => 'FrenteEstrategicoController@data'));

//Evidencia (Acticidad de Mejoramiento)
Route::get('evidencia/data/data/{id}', array(
    'as' => 'admin.evidencia.datos',
    'uses' => 'EvidenciaController@datos'
));
//Rutas CRUD Evidencia  (Acticidad de Mejoramiento)
Route::get('actividades_mejoramiento/evidencia/{id}', array(
    'as' => 'admin.evidencia.index',
    'uses' => 'EvidenciaController@index'
));
Route::get('actividades_mejoramiento/evidencia/create/{id}', array(
    'as' => 'admin.evidencia.create',
    'uses' => 'EvidenciaController@create'
));
// Route::resource('evidencia', 'EvidenciaController', ['as' => 'admin'])->except(['index', 'create']);
Route::get('actividades_mejoramiento/evidencia/{id}/edit', array(
    'as' => 'admin.evidencia.edit',
    'uses' => 'EvidenciaController@edit'
));
Route::post('actividades_mejoramiento/evidencia', array(
    'as' => 'admin.evidencia.store',
    'uses' => 'EvidenciaController@store'
));
Route::put('actividades_mejoramiento/evidencia/{evidencia}', array(
    'as' => 'admin.evidencia.update',
    'uses' => 'EvidenciaController@update'
));
Route::delete('actividades_mejoramiento/evidencia/{evidencia}', array(
    'as' => 'admin.evidencia.destroy',
    'uses' => 'EvidenciaController@destroy'
));

//CalificaActividades
Route::get('actividades_mejoramiento/califica_actividad/{id}', array(
    'as' => 'admin.califica_actividad.index',
    'uses' => 'CalificaActividadController@index'
));
Route::resource('actividades_mejoramiento/califica_actividad', 'CalificaActividadController', ['as' => 'admin'])->except(['show', 'index']);
Route::get('califica_actividad/data/data/{id}', array('as' => 'admin.califica_actividad.data',
    'uses' => 'CalificaActividadController@data'));

//Caracateristicas
Route::resource('caracteristicas', 'CaracteristicasController', ['as' => 'admin']);
Route::get(
    'caracteristicas/data/data',
    array('as' => 'admin.caracteristicas.data', 'uses' => 'CaracteristicasController@data')
);
Route::get('caracteristicas/factor/{id}', 'CaracteristicasController@factores');

//Ambitos
Route::resource('ambito', 'AmbitoController', ['as' => 'admin']);
Route::get('ambito/data/data', array('as' => 'admin.ambito.data', 'uses' => 'AmbitoController@data'));

//Aspectos
Route::resource('aspectos', 'AspectoController', ['as' => 'admin']);
Route::get('aspectos/data/data', array('as' => 'admin.aspectos.data', 'uses' => 'AspectoController@data'));

//Sedes
Route::resource('sedes', 'SedeController', ['as' => 'admin']);
Route::get('sedes/data/data', array('as' => 'admin.sedes.data', 'uses' => 'SedeController@data'));

//Facultades
Route::resource('facultades', 'FacultadController', ['as' => 'admin']);
Route::get('facultades/data/data', array('as' => 'admin.facultades.data', 'uses' => 'FacultadController@data'));

//Programas académicos
Route::resource('programas_academicos', 'ProgramaAcademicoController', ['as' => 'admin']);
Route::get('programas_academicos/data/data', array('as' => 'admin.programas_academicos.data',
    'uses' => 'ProgramaAcademicoController@data'));

Route::get('programas_academicos/sedes/{id_institucion}', array(
    'as' => 'admin.programas_academicos.obtener_sedes',
    'uses' => 'ProgramaAcademicoController@ObtenerSedes'
));

//Procesos para programas
Route::resource('procesos_programas', 'ProcesoProgramaController', ['as' => 'admin']);
Route::get('procesos_programas/data/data', array(
    'as' => 'admin.procesos_programas.data',
    'uses' => 'ProcesoProgramaController@data'
));
Route::get('procesos_programas/{id_sede}/{id_facultad}', array(
    'as' => 'admin.procesos_programas.obtener_programas',
    'uses' => 'ProcesoProgramaController@ObtenerProgramas'
));

//Procesos institucionales
Route::resource('procesos_institucionales', 'ProcesoInstitucionalController', ['as' => 'admin']);
Route::get('procesos_institucionales/data/data', array(
    'as' => 'admin.procesos_institucionales.data',
    'uses' => 'ProcesoInstitucionalController@data'
));

//Procesos usuarios
Route::get('procesos_usuarios/proceso/{id}', array(
    'as' => 'admin.procesos_usuarios.show',
    'uses' => 'ProcesoUsuarioController@show'
));
Route::post('procesos_usuarios/proceso/asignar_usuarios/{id}', array(
    'as' => 'admin.procesos_usuarios.asignar',
    'uses' => 'ProcesoUsuarioController@asignarUsuarios'
));
Route::get('procesos_usuarios/data/{id}', array(
    'as' => 'admin.procesos_usuarios.data',
    'uses' => 'ProcesoUsuarioController@data'
));

//Grupos de Interes
Route::resource('grupos_interes', 'GruposInteresController', ['as' => 'admin']);
Route::get('grupos_interes/data/data', array('as' => 'admin.grupos_interes.data', 'uses' => 'GruposInteresController@data'));

//Reportes pdf con encuestas y documentos institucionales
Route::post('informe_general/descargar', array(
    'as' => 'admin.informe_general.descargar',
    'uses' => 'pageController@pdf_reporte'
));

//Historial
Route::get('historial', array(
    'as' => 'admin.historial',
    'uses' => 'HistorialController@index'
));
Route::get('historial/proceso/{anio}', array(
    'as' => 'admin.historial.procesos.anio',
    'uses' => 'HistorialController@obtenerProceso'
));

Route::get('historial/datos_graficas/{idProceso}', array(
    'as' => 'admin.historial.datos_graficas',
    'uses' => 'HistorialController@obtenerDatosGraficas'
));
Route::get('historial/caracteristicas/{idFactor}', array(
    'as' => 'admin.historial.obtener_caracteristicas',
    'uses' => 'HistorialController@obtenerCaracteristicas'
));
Route::post('historial/filtro_documental/{idProceso}', array(
    'as' => 'admin.historial.filtro_documental',
    'uses' => 'HistorialController@filtroDocumental'
));
Route::post('historial/filtro_encuestas/{idProceso}', array(
    'as' => 'admin.historial.filtro_encuestas',
    'uses' => 'HistorialController@filtroEncuestas'
));


//Caracteristicas Mejoramiento
Route::resource('caracteristicas_mejoramiento', 'CaracteristicasMejoramientoController', ['as' => 'admin']);
Route::get('caracteristicas_mejoramiento/data/data', array(
    'as' => 'admin.caracteristicas_mejoramiento.data',
    'uses' => 'CaracteristicasMejoramientoController@data'));
Route::get('caracteristicas_mejoramiento/data_doc/data_doc', array(
    'as' => 'admin.caracteristicas_mejoramiento.data_doc',
    'uses' => 'CaracteristicasMejoramientoController@data_doc'));

//Responsables
Route::resource('responsables', 'ResponsablesController', ['as' => 'admin']);
Route::get('responsables/data/data', array(
                        'as' => 'admin.responsables.data',
                        'uses' => 'ResponsablesController@data'));

//Actividades de mejoramiento
Route::resource('actividades_mejoramiento', 'ActividadesMejoramientoController', ['as' => 'admin'])->except(['show']);
Route::get('actividades_mejoramiento/{id}', array(
                        'as' => 'admin.actividades_mejoramiento.datos',
                        'uses' => 'ActividadesMejoramientoController@create'));
Route::get('estado_actividades/{id}', array(
                        'as' => 'admin.actividades_mejoramiento.estado',
                        'uses' => 'ActividadesMejoramientoController@estado'));
Route::get('actividades_mejoramiento/data/data', array(
                        'as' => 'admin.actividades_mejoramiento.data',
                        'uses' => 'ActividadesMejoramientoController@data'));

//informe Autoevaluación
Route::resource('informes_autoevaluacion', 'InformeAutoevaluacionController', [
                'as' => 'admin'])->except(['index', 'show', 'edit', 'update', 'destroy']);


//informes plan de mejoramiento
Route::get('informes_mejoramiento', array(
    'as' => 'admin.informes_mejoramiento',
    'uses' => 'ReportesPlanMejoramientoController@index'
));

Route::get('informes_mejoramiento/datos', array(
    'as' => 'admin.informes_mejoramiento.datos',
    'uses' => 'ReportesPlanMejoramientoController@obtenerDatos'
));

Route::post('informes_mejoramiento/filtrar_factores', array(
    'as' => 'admin.informes_mejoramiento.filtrar_factores',
    'uses' => 'ReportesPlanMejoramientoController@filtro_factores'
));

Route::get('notificaciones', array(
    'as' => 'admin.notificaciones',
    'uses' => 'NotificacionesController@index'
));

Route::get('seguridad', array(
    'as' => 'admin.seguridad',
    'uses' => 'SeguridadController@index'
));
Route::get('seguridad/data', array(
    'as' => 'admin.seguridad.data',
    'uses' => 'SeguridadController@data'
));

//Fechas de Corte
Route::resource('fechacorte', 'FechaCorteController', ['as' => 'admin']);
Route::get('fechacorte/data/data', array('as' => 'admin.fechacorte.data',
    'uses' => 'FechaCorteController@data'));

//Consolidacion de Factores
Route::resource('consolidacion_factores', 'ConsolidacionController', ['as' => 'admin']);
Route::get('consolidacion_factores/data/data', array('as' => 'admin.consolidacion_factores.data',
    'uses' => 'ConsolidacionController@data'));

Route::get('calendario', array('as' => 'admin.calendario', 'uses' => 'ActividadesMejoramientoController@calendario'));
