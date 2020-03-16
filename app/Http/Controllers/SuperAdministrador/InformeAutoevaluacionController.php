<?php

namespace App\Http\Controllers\SUperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\CalificaActividad;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Consolidacion;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\FrenteEstrategico;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Metodologia;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\SolucionEncuesta;

use PhpOffice\PhpWord\TemplateProcessor;

class InformeAutoevaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return view('autoevaluacion.SuperAdministrador.InformeAutoevaluacion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('autoevaluacion.SuperAdministrador.InformeAutoevaluacion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Enfocada a completar los cuadros de programa e institucion con frentes etrategicos
         */
        try{
            if($request->file('file')){
                $path = public_path().'/uploads';
                $files = $request->file('file');
                foreach($files as $file){
                    $fileName = ("foto.").$file->extension();
                    $file->move($path, $fileName);
                    dd($path);
                }
            }

            $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
            })
                ->with('Caracteristicas.factor', 'responsable.usuarios', 'responsable.cargo')
                ->get();

            if(!empty($actividades)){
                $sum = 4 / 0;
            }

            $proceso = Proceso::where('PK_PCS_Id', '=', session()->get('id_proceso'))->first();
            $programa = $proceso->programa;
            $facultad = $proceso->programa->facultad;
            $sede = $proceso->programa->sede;
            $institucion = $proceso->programa->sede->institucion;
            $metodologia_query = Metodologia::where('PK_MTD_Id', '=', $institucion->FK_ITN_Metodologia)->first();
            $frentesEstrategicos = FrenteEstrategico::where('FK_FES_Institucion', '=', $institucion->PK_ITN_Id)->get();

            $nombreArchivo = str_replace(' ', '_', $programa->PAC_Nombre) . str_replace(' ', '_', $sede->SDS_Nombre) . str_replace(' ', '_', $institucion->ITN_Nombre);

            $documento = new TemplateProcessor('Plantila_AutoEvaluacion_EAAG008_V2.docx');

            if(is_null($request->get('IAT_Titulo_Uno'))){
                $documento->setValue('titulo_1', 'NOMBRE DEL MACROPROCESO');
            }
            else{
                $documento->setValue('titulo_1', $request->get('IAT_Titulo_Uno'));
            }

            if(is_null($request->get('IAT_Titulo_Dos'))){
                $documento->setValue('titulo_2', 'NOMBRE DEL PROCESO');
            }
            else{
                $documento->setValue('titulo_2', $request->get('IAT_Titulo_Dos'));
            }

            if(is_null($request->get('IAT_Titulo_Tres'))){
                $documento->setValue('titulo_3', 'GUÍA INFORME DE AUTOEVALUACIÓN DE PROGRAMAS ACADÉMICOS');
            }
            else{
                $documento->setValue('titulo_3', $request->get('IAT_Titulo_Tres'));
            }

            $img_path_jpg = public_path().'/uploads/foto.jpg';
            $img_path_png = public_path().'/uploads/foto.png';
            $img_path_jpeg = public_path().'/uploads/foto.jpeg';
            $img_ucundi = public_path().'/uploads/icon-ucundi.png';

            // dd(@getimagesize($img_path_jpg), @getimagesize($img_path_png), $img_path_jpeg);

            if(@getimagesize($img_path_jpg)){
                $documento->setImageValue('foto', array('path' => $img_path_jpg, 'width' => 100, 'height' => 100, 'ratio' => true));
            }
            elseif(@getimagesize($img_path_png)){
                $documento->setImageValue('foto', array('path' => $img_path_png, 'width' => 100, 'height' => 100, 'ratio' => true));
            }
            elseif(@getimagesize($img_path_jpeg)){
                $documento->setImageValue('foto', array('path' => $img_path_jpeg, 'width' => 100, 'height' => 100, 'ratio' => true));
            }
            else{
                $documento->setImageValue('foto', array('path' => $img_ucundi, 'width' => 100, 'height' => 100, 'ratio' => true));
            }



            $documento->setValue('nombre_institucion', $institucion->ITN_Nombre);
            $documento->setValue('domicilio_institucion', $institucion->ITN_Domicilio);
            $documento->setValue('caracter_institucion', $institucion->ITN_Caracter);
            $documento->setValue('snies_institucion', $institucion->ITN_CodigoSNIES);
            $documento->setValue('norma_creacion', $institucion->ITN_Norma_Creacion);
            $documento->setValue('estudiante_matriculados', $institucion->ITN_Estudiantes);
            $documento->setValue('metodologia', $metodologia_query->MTD_Nombre);
            $documento->setValue('planta', $institucion->ITN_Profesor_Planta);
            $documento->setValue('t_c', $institucion->ITN_Profesor_TCompleto);
            $documento->setValue('m_t', $institucion->ITN_Profesor_TMedio);
            $documento->setValue('catedra', $institucion->ITN_Profesor_Catedra);
            $documento->setValue('graduados', $institucion->ITN_Graduados);
            $documento->setValue('boletin_mes', $institucion->ITN_FuenteBoletinMes);
            $documento->setValue('boletin_anio', $institucion->ITN_FuenteBoletinAnio);
            $documento->setValue('mision', $institucion->ITN_Mision);
            $documento->setValue('vision', $institucion->ITN_Vision);
            $documento->setValue('nombre_programa', $programa->PAC_Nombre);
            $documento->setValue('formacion', $programa->PAC_Nivel_Formacion);
            $documento->setValue('titulo', $programa->PAC_Titutlo_Otorga);
            $documento->setValue('situacion', $programa->PAC_Situacion_Programa);
            $documento->setValue('anio_inicio_act', $programa->PAC_Anio_Inicio_Actividades);
            $documento->setValue('lugar_funcionamiento', $programa->PAC_Lugar_Funcionamiento);
            $documento->setValue('norma_creacion_programa', $programa->PAC_Norma_Interna);
            $documento->setValue('resolucion_r_c', $programa->PAC_Resolucion_Registro);
            $documento->setValue('snies', $programa->PAC_Codigo_SNIES);
            $documento->setValue('creditos', $programa->PAC_Numero_Creditos);
            $documento->setValue('duracion', $programa->PAC_Duracion);
            $documento->setValue('jornada', $programa->PAC_Jornada);
            $documento->setValue('duracion_semestre', $programa->PAC_Duracion_Semestre);
            $documento->setValue('periodicidad', $programa->PAC_Periodicidad);
            $documento->setValue('adscrito', $programa->PAC_Adscrito);
            $documento->setValue('area_conocimiento', $programa->PAC_Area_Conocimiento);
            $documento->setValue('nucleo_basico', $programa->PAC_Nucleo);
            $documento->setValue('area_formacion', $programa->PAC_Area_Formacion);
            $documento->setValue('estudiantes_actual', $programa->PAC_Estudiantes);
            $documento->setValue('no_egresados', $programa->PAC_Egresados);
            $documento->setValue('smlv', $programa->PAC_Valor_Matricula);

            /**
             * Uso de tablas
             */
            $documento->cloneRow('no_frente_estrategico', sizeof($frentesEstrategicos));

            for($i = 0; $i < sizeof($frentesEstrategicos); $i++) {
                $lista = $i + 1;
                $documento->setValue('no_frente_estrategico#'.$lista, $lista);
                $documento->setValue('nombre_frente_estrategico#'.$lista, $frentesEstrategicos[$i]->FES_Nombre);
                $documento->setValue('descripcion_frente_estrategico#'.$lista, $frentesEstrategicos[$i]->FES_Descripcion);
            }

            /**
             * Enfocado a traer la ponderacion y demas datos que necesita la tabla de resultados
             */
            $labelsCaracteristica = [];
            $dataCaracteristicas = [];
            // $dataFactor = [];
            $contador_caracteristicas = 0;
            $contador_factores = 0;
                // $j = 3;
            for($j = 0; $j < sizeof(Factor::all()); $j++) {
                $contador_factores++;
                $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query) {
                    return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                })
                    ->where('FK_CRT_Factor', '=', $contador_factores)
                    ->groupby('PK_CRT_Id')
                    ->get();

                $factor = Factor::where('PK_FCT_Id', $contador_factores)->first();
                foreach ($caracteristicas as $caracteristica) {
                    array_push($labelsCaracteristica, $caracteristica->CRT_Nombre);
                    $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query) {
                        return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                    })
                        ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica) {
                            return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
                        })
                        ->with('respuestas.ponderacion')
                        ->get();
                    $totalPonderacion = 0;
                    $prueba = $soluciones->count();
                    foreach ($soluciones as $solucion) {
                        $totalPonderacion = $totalPonderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                    }
                    $prueba = $totalPonderacion / $prueba;
                    array_push($dataCaracteristicas, $prueba);
                }
                $stringMinusculasFactor = mb_strtolower($factor->FCT_Nombre, 'UTF-8');
                $documento->setValue('factor#'.$j, ucfirst($stringMinusculasFactor));
                $documento->setValue('factorMayus#'.$j, mb_strtoupper($stringMinusculasFactor));

                for($k = 0; $k < sizeof($labelsCaracteristica); $k++) {
                    $stringMinusculas = mb_strtolower ($labelsCaracteristica[$k], 'UTF-8');
                    $documento->setValue('caracteristica#'.$contador_caracteristicas, ucfirst($stringMinusculas) );
                    $contador_caracteristicas++;
                }

                $ponderacion = round(array_sum($dataCaracteristicas)/count($dataCaracteristicas));

                if($ponderacion >= 0 && $ponderacion <= 4){
                    $documento->setValue('tipo1_'.$j, " ");
                    $documento->setValue('tipo2_'.$j, " ");
                    $documento->setValue('tipo3_'.$j, "X");
                }
                elseif($ponderacion > 4 && $ponderacion <= 7){
                    $documento->setValue('tipo1_'.$j, " ");
                    $documento->setValue('tipo2_'.$j, "X");
                    $documento->setValue('tipo3_'.$j, " ");
                }
                elseif($ponderacion > 7 && $ponderacion <= 10){
                    $documento->setValue('tipo1_'.$j, "X");
                    $documento->setValue('tipo2_'.$j, " ");
                    $documento->setValue('tipo3_'.$j, " ");
                }

                $documento->setValue('ponderacion#'.$j, $ponderacion);
            }   //FOR

            /**
             * Dedicado para traer la catidad total de encuestados
             */
            $gruposI = GrupoInteres::all();
            $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))->first();
            $encuestados = Encuestado::with('grupos')
                ->where('FK_ECD_Encuesta', '=', $encuesta->PK_ECT_Id ?? null)
                ->selectRaw('*, COUNT(FK_ECD_GrupoInteres) as cantidad')
                ->groupby('FK_ECD_GrupoInteres')
                ->get();

            $totalEstudiates = 0;
            $coberturaEstudiantes = 0;
            $totalDocentes = 0;
            $coberturaDocentes = 0;
            $totalAdmin = 0;
            $coberturaAdmin = 0;
            $totalDirectivo = 0;
            $coberturaDirectivo = 0;
            $totalAdmin_Directivo = 0;
            $coberturaAdmin_Directivo = 0;
            $totalEgresados = 0;
            $coberturaEgresados = 0;
            $totalEmpresa = 0;
            $coberturaEmpresa = 0;

            for($l = 0; $l < count($encuestados); $l++){
                //Revisar similar_text => https://diego.com.es/comparacion-de-strings-en-php
                if(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "estudiante") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "estudiantes") == 0){
                    $totalEstudiates = $totalEstudiates + $encuestados[$l]->cantidad;
                    $coberturaEstudiantes = ($totalEstudiates * 100) / $programa->PAC_Estudiantes;
                }
                elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DOCENTES") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "docentes") == 0){
                    $totalDocentes = $totalDocentes + $encuestados[$l]->cantidad;
                    $coberturaDocentes = ($encuestados[$l]->cantidad * 100) / $programa->PAC_Docentes_Actual;
                }
                elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVOS ACADEMICOS") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVO ACADEMICO") == 0
                || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "administrativo") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "administrativos") == 0){
                    if(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVOS ACADEMICOS") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVO ACADEMICO") == 0){
                        $totalDirectivo = $totalDirectivo + $encuestados[$l]->cantidad;
                        $coberturaDirectivo = $encuestados[$l]->cantidad * 100 / ($programa->PAC_Directivos_Academicos);
                    }
                    else{
                        $totalAdmin = $totalAdmin + $encuestados[$l]->cantidad;
                        $coberturaAdmin = $encuestados[$l]->cantidad * 100 / $programa->PAC_Administrativos;
                    }
                    $totalAdmin_Directivo = $totalDirectivo + $totalAdmin;
                    $coberturaAdmin_Directivo = $coberturaDirectivo + $coberturaAdmin;
                }
                elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "graduados") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "egresados") == 0){
                    $totalEgresados = $totalEgresados + $encuestados[$l]->cantidad;
                    $coberturaEgresados = ($encuestados[$l]->cantidad * 100 / $programa->PAC_Egresados_Cinco);
                }
                elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "empresarios") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "empleadores") == 0){
                    $totalEmpresa = $totalEmpresa + $encuestados[$l]->cantidad;
                    $coberturaEmpresa = ($encuestados[$l]->cantidad * 100 / $programa->PAC_Empresarios);
                }
            }
            $coberturaAdmin_Directivo = $coberturaAdmin_Directivo / 2;


            $documento->setValue('total_estudiantes', $programa->PAC_Estudiantes);
            $documento->setValue('solucion_estudiantes', $totalEstudiates);
            $documento->setValue('cobertura_estudiantes', round($coberturaEstudiantes."%", 2));
            $documento->setValue('total_docentes',"120");
            $documento->setValue('solucion_docentes', $totalDocentes);
            $documento->setValue('cobertura_docentes', round($coberturaDocentes."%"), 2);
            $documento->setValue('total_admin', "18");
            $documento->setValue('solucion_admin', $totalAdmin_Directivo);
            $documento->setValue('cobertura_admin', round($coberturaAdmin_Directivo."%"), 2);
            $documento->setValue('total_egresados', "439");
            $documento->setValue('solucion_egresados', $totalEgresados);
            $documento->setValue('cobertura_egresados', round($coberturaEgresados."%"), 2);
            $documento->setValue('total_empresa', "10");
            $documento->setValue('solucion_empresa', $totalEmpresa);
            $documento->setValue('cobertura_empresa', round($coberturaEmpresa)."%", 2);


            /**
             * Deciado a traer los resultados valorizados por grupo de interes
             */
            /**Para los resultados de ponderacion de los arryas */
            $datosPorCaracteristica = [];
            $datosPorFactor = [];
            $grupoFactores = [];
            /**Para los labels de os arrays */
            $label_datosPorCaracteristica = [];
            $label_datosPorFactor = [];
            $label_grupoFactores = [];

            $labelGrupoInteres = [];
            $totalPonderaciones = [];
            $contPonderaciones = [];

            $ponderacion = [];

            $totalGruposI = GrupoInteres::all();

            /**
             * Inicializar el array para poder guardar datos
             */
            for($i = 0; $i < count($totalGruposI); $i++){
                array_push($labelGrupoInteres, "");
                array_push($totalPonderaciones, 0);
                array_push($contPonderaciones, 0);
                array_push($ponderacion, 0);
            }

            $contador_caracteristicas = 0;
            $contador_factores = 0;

            for($j = 0; $j < sizeof(Factor::all()); $j++) {
                $contador_factores++;
                $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query) {
                    return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                })
                    ->where('FK_CRT_Factor', '=', $contador_factores)
                    ->groupby('PK_CRT_Id')
                    ->get();

                $factor = Factor::where('PK_FCT_Id', $contador_factores)->first();
                foreach ($caracteristicas as $caracteristica) {
                    $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query) {
                        return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                    })
                        ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica) {
                            return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
                        })
                        ->with('respuestas.ponderacion')
                        ->with('encuestados.grupos')
                        ->get();
                    $totalPonderacion = 0;

                    foreach ($soluciones as $solucion) {
                        if($totalGruposI[0]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[0] = $totalPonderaciones[0] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[0] = $totalGruposI[0]->GIT_Nombre;
                            $contPonderaciones[0] ++ ;
                        }
                        elseif($totalGruposI[1]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[1] = $totalPonderaciones[1] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[1] = $totalGruposI[1]->GIT_Nombre;
                            $contPonderaciones[1] ++ ;
                        }
                        elseif($totalGruposI[2]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[2] = $totalPonderaciones[2] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[2] = $totalGruposI[2]->GIT_Nombre;
                            $contPonderaciones[2] ++ ;
                        }
                        elseif($totalGruposI[3]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[3] = $totalPonderaciones[3] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[3] = $totalGruposI[3]->GIT_Nombre;
                            $contPonderaciones[3] ++ ;
                        }
                        elseif($totalGruposI[4]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[4] = $totalPonderaciones[4] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[4] = $totalGruposI[4]->GIT_Nombre;
                            $contPonderaciones[4] ++ ;
                        }
                        elseif($totalGruposI[5]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[5] = $totalPonderaciones[5] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[5] = $totalGruposI[5]->GIT_Nombre;
                            $contPonderaciones[5] ++ ;
                        }
                        elseif($totalGruposI[6]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[6] = $totalPonderaciones[6] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[6] = $totalGruposI[6]->GIT_Nombre;
                            $contPonderaciones[6] ++ ;
                        }
                        elseif($totalGruposI[7]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[7] = $totalPonderaciones[7] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[7] = $totalGruposI[7]->GIT_Nombre;
                            $contPonderaciones[7] ++ ;
                        }
                        elseif($totalGruposI[8]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[8]= $totalPonderaciones[8] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[8] = $totalGruposI[8]->GIT_Nombre;
                            $contPonderaciones[8] ++ ;
                        }
                        elseif($totalGruposI[9]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                            $totalPonderaciones[9] = $totalPonderaciones[9] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            $labelGrupoInteres[9] = $totalGruposI[9]->GIT_Nombre;
                            $contPonderaciones[9] ++ ;
                        }
                    }

                    for($k = 0; $k < count($totalGruposI); $k++){
                        if($totalPonderaciones[$k] != 0) {
                            $ponderacion[$k] = $totalPonderaciones[$k] / $contPonderaciones[$k];
                        }
                    }

                    for($l = 0; $l < count($totalGruposI); $l++){
                        if(!isset($labelGrupoInteres[$l])) {
                            $labelGrupoInteres[$l] = 0;
                        }
                        if(!isset($ponderacion[$l]) || $ponderacion[$l] == 0) {
                            $ponderacion[$l] = 0;
                        }
                    }

                    array_push($datosPorCaracteristica,     $ponderacion[0],
                                                            $ponderacion[1],
                                                            $ponderacion[2],
                                                            $ponderacion[3],
                                                            $ponderacion[4],
                                                            $ponderacion[5],
                                                            $ponderacion[6],
                                                            $ponderacion[7],
                                                            $ponderacion[8],
                                                            $ponderacion[9]
                                                    );
                    array_push($datosPorFactor, $datosPorCaracteristica);
                    unset($datosPorCaracteristica);
                    $datosPorCaracteristica = [];

                    array_push($label_datosPorCaracteristica,   $labelGrupoInteres[0],
                                                                $labelGrupoInteres[1],
                                                                $labelGrupoInteres[2],
                                                                $labelGrupoInteres[3],
                                                                $labelGrupoInteres[4],
                                                                $labelGrupoInteres[5],
                                                                $labelGrupoInteres[6],
                                                                $labelGrupoInteres[7],
                                                                $labelGrupoInteres[8],
                                                                $labelGrupoInteres[9]
                                                );
                    array_push($label_datosPorFactor, $label_datosPorCaracteristica);
                    unset($label_datosPorCaracteristica);
                    $label_datosPorCaracteristica = [];

                }//foreach caracteristicas

                array_push($grupoFactores, $datosPorFactor);
                unset($datosPorFactor);
                $datosPorFactor = [];

                array_push($label_grupoFactores, $label_datosPorFactor);
                unset($label_datosPorFactor);
                $label_datosPorFactor = [];
            }

            /**
             * Ponderacion de factores
             */
            $ponderacionFactores = [];
            array_push($ponderacionFactores , 13, 12, 12, 15, 8, 9, 7, 8, 7, 9);

            /**Calculo para los porcentaje de acuerdo a los Factores */
            $sumaPorFactor = [];
            $resultadoPorFactor = [];
            $porcentajeFactor = [];

            $sumaPorFactorGrupos = [];
            $resultadoPorFactorGrupos = [];

            $promResulPorFactGrup = [];
            /**
             * Array para el promedio por factor
             */
            $promedioFactor = [];

            for($k = 0; $k < count($grupoFactores); $k++){
                for($i = 0; $i < count($grupoFactores[0][0]); $i++){
                    $suma = 0;
                    for($j = 0; $j < count($grupoFactores[$k]); $j++){
                        $suma = $suma + $grupoFactores[$k][$j][$i];
                    }
                    if($suma == 0){
                        array_push($sumaPorFactor, 0);
                    }
                    else
                    {
                        array_push( $sumaPorFactor, ( ($suma / count($grupoFactores[$k]))) * 10 );
                    }
                }
                array_push($resultadoPorFactor, $sumaPorFactor);
                $promedio = array_sum($sumaPorFactor)/6;    //Grupos de interes FIjos
                array_push($promedioFactor, $promedio);

                $promedioFactorIndicador = ($ponderacionFactores[$k] * ($promedioFactor[$k] / 100));

                array_push($porcentajeFactor, $promedioFactorIndicador);

                unset($sumaPorFactor);
                $sumaPorFactor = [];

            }

            for($i = 0;$i < count($grupoFactores);$i++ ){
                for($j =0;$j < count($grupoFactores[$i]);$j++) {
                    $suma = 0;
                    $ponderacionPorCarac = 0;
                    for($k = 0;$k < count($grupoFactores[$i][$j]);$k++ ){
                        $suma = $suma + $grupoFactores[$i][$j][$k];
                    }
                    if($suma == 0){
                        array_push($sumaPorFactorGrupos, 0);
                    }
                    else
                    {
                        $ponderacionPorCarac = ($ponderacionFactores[$i] / count($grupoFactores[$i])) * (($suma / 6) / 10);
                        array_push($sumaPorFactorGrupos, $ponderacionPorCarac );
                    }
                }
                array_push($resultadoPorFactorGrupos, $sumaPorFactorGrupos);

                $promedioPonFactor = array_sum($sumaPorFactorGrupos) / count($sumaPorFactorGrupos);
                array_push($promResulPorFactGrup, $promedioPonFactor);

                unset($sumaPorFactorGrupos);
                $sumaPorFactorGrupos = [];
            }

            $contCaracFactor = 0;
            $contPC = 0;
            for($i = 0;$i < count($grupoFactores); $i++){
                for($j = 0;$j < 6;$j++){
                    $contCaracFactor ++;
                    if($resultadoPorFactor[$i][$j] == 0 || !$resultadoPorFactor[$i][$j]){
                        $documento->setValue('resultado#'.$contCaracFactor, "");
                    }
                    else{
                        $documento->setValue('resultado#'.$contCaracFactor, round($resultadoPorFactor[$i][$j])."%");
                    }
                }
                for($j = 0;$j < count($resultadoPorFactorGrupos[$i]);$j++){
                    $contPC++;
                    if($resultadoPorFactorGrupos[$i][$j] == 0 || !$resultadoPorFactorGrupos[$i][$j]){
                        $documento->setValue('pc#'.$contPC, "");
                    }
                    else{
                        $documento->setValue('pc#'.$contPC, round($resultadoPorFactorGrupos[$i][$j], 1)."%");
                    }
                }

                $documento->setValue('promedio#'.$i, round($promedioFactor[$i], 1)."%");
                $documento->setValue('ponderacionFactor#'.$i, $ponderacionFactores[$i]."%");
                $documento->setValue('porcentajeFactor#'.$i, round($porcentajeFactor[$i], 1)."%");
                $documento->setValue('promPC#'.$i, round($promResulPorFactGrup[$i], 1)."%");
            }

            $promedioPorcentajeValor = array_sum($porcentajeFactor) / count($porcentajeFactor);
            $documento->setValue('promedioPorcentajeValor', round($promedioPorcentajeValor, 1));

            for($i = 0;$i < count($grupoFactores); $i++){
                if($promedioFactor[$i] >= 0 && $promedioFactor[$i] < 40){
                    $documento->setValue('gradoCumplimiento#'.$i, "No se cumple");
                }
                elseif($promedioFactor[$i] >= 40 && $promedioFactor[$i] < 55){
                    $documento->setValue('gradoCumplimiento#'.$i, "Se cumple insatisfactoriamente");
                }
                elseif($promedioFactor[$i] >= 55 && $promedioFactor[$i] < 70){
                    $documento->setValue('gradoCumplimiento#'.$i, "Se cumple aceptablemente");
                }
                elseif($promedioFactor[$i] >= 70 && $promedioFactor[$i] < 85){
                    $documento->setValue('gradoCumplimiento#'.$i, "Se cumple en alto grado");
                }
                elseif($promedioFactor[$i] >= 85 && $promedioFactor[$i] <= 100){
                    $documento->setValue('gradoCumplimiento#'.$i, "Se cumple plenamente");
                }
            }

            $contadorConsolida = [];
            for($i = 0;$i < count($grupoFactores); $i++){
                $contadorConsolida[$i] = 0;
            }


            $consolidaciones = Consolidacion::where('FK_CNS_Proceso', '=', session()->get('id_proceso'))
                    ->with('caracteristica.factor')
                    ->get();

            for($i = 0;$i < count($grupoFactores); $i++){
                $valida = $i + 1;
                for($j = 0;$j < count($consolidaciones);$j++){
                    if($consolidaciones[$j]->caracteristica->factor->FCT_Identificador == $valida){
                        $contadorConsolida[$i] ++;
                    }
                }
            }

            for($i = 0;$i < count($grupoFactores); $i++){
                $factor = $i + 1;
                $documento->cloneRow('no_fortalezaFactor'.$factor, $contadorConsolida[$i]);
                for($j = 0;$j < $contadorConsolida[0]; $j++){
                    $lista = $j + 1;
                    $documento->setValue('no_fortalezaFactor'.$factor.'#'.$lista, $consolidaciones[$j]->CNS_Fortaleza);
                    $documento->setValue('no_debilidadFactor'.$factor.'#'.$lista, $consolidaciones[$j]->CNS_Debilidad);
                }
            }

            $documento->cloneRow('no_fortalezaSintesis', count($consolidaciones));
            for($i = 0;$i < count($consolidaciones); $i++){
                $lista = $i + 1;
                $documento->setValue('no_fortalezaSintesis#'.$lista, $consolidaciones[$i]->CNS_Fortaleza);
                $documento->setValue('no_debilidadSintesis#'.$lista, $consolidaciones[$i]->CNS_Debilidad);
            }

            $documento->cloneRow('actFac', count($actividades));
            for($i = 0;$i < count($actividades); $i++){
                $lista = $i + 1;
                $documento->setValue('actFac#'.$lista, $actividades[$i]->Caracteristicas->factor->FCT_Identificador);
                $documento->setValue('actAc#'.$lista, "");
                $documento->setValue('actNom#'.$lista, $actividades[$i]->ACM_Nombre);
                $documento->setValue('actFi#'.$lista, $actividades[$i]->ACM_Fecha_Inicio->format('d-m-Y'));
                $documento->setValue('actFf#'.$lista, $actividades[$i]->ACM_Fecha_Fin->format('d-m-Y'));
                $documento->setValue('actInd#'.$lista, "");
                $documento->setValue('actRes#'.$lista, $actividades[$i]->responsable->usuarios->name . " " . $actividades[$i]->responsable->usuarios->lastname);
                $documento->setValue('actCar#'.$lista, $actividades[$i]->responsable->cargo->CAA_Cargo);
                $documento->setValue('actMet#'.$lista, "");
                $documento->setValue('actDes#'.$lista, $actividades[$i]->ACM_Descripcion);
                $documento->setValue('actRec#'.$lista, "");
            }

            $calificaciones = CalificaActividad::whereHas('actividadesMejoramiento')
                ->with('actividadesMejoramiento.Caracteristicas.factor')
                ->orderBy('CLA_Calificacion', 'desc')
                ->get();

                // dd($calificaciones);

            for($i = 0; $i < count($grupoFactores); $i ++){
                $identificador = $i + 1;
                if(empty($calificaciones)){
                    for($j = 0; $j < count($calificaciones); $j ++){
                        if($calificaciones[$j]->actividadesMejoramiento->Caracteristicas->factor->FCT_Identificador == $identificador){
                            $documento->setValue('accion_implementada#'.$i, $calificaciones[$j]->actividadesMejoramiento->ACM_Nombre);
                            $documento->setValue('seguimiento#'.$i, $calificaciones[$j]->actividadesMejoramiento->ACM_Descripcion);
                        }
                        else{
                            $documento->setValue('accion_implementada#'.$i, "");
                            $documento->setValue('seguimiento#'.$i, "");
                        }
                    break;
                    }
                }
                else{
                    $documento->setValue('accion_implementada#'.$i, "");
                    $documento->setValue('seguimiento#'.$i, "");
                }

            }

            /**
             * Path para descargar
             */
            // $ruta = public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx";
            // dd(public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx");

            $documento->saveAs('InformeAutoevaluacion_' . $nombreArchivo . '.docx');

            /**
             * Eliminacion de imagenes.
             */
            if(@getimagesize($img_path_jpg)){
                unlink($img_path_jpg);
            }
            elseif(@getimagesize($img_path_png)){
                unlink($img_path_png);
            }
            elseif(@getimagesize($img_path_jpeg)){
                unlink($img_path_jpeg);
            }

            $pathToFile = public_path(). '\InformeAutoevaluacion_'. $nombreArchivo .'.docx';

            return response()->download($pathToFile);

        }
        catch(\Exception $ex){
            dd($ex);
            if(strcasecmp($ex->getMessage(), "Division by zero") == 0){
                return redirect()->back()->with('division_zero','Mensaje Error');
            }
            else{
                return redirect()->back()->with('error','Mensaje Error');
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
