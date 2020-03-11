<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;
use App\Models\Autoevaluacion\CalificaActividad;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Consolidacion;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\FrenteEstrategico;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Metodologia;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\SolucionEncuesta;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class AmbitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_AMBITOS')->except('show');
        $this->middleware(['permission:MODIFICAR_AMBITOS', 'permission:VER_AMBITOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_AMBITOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_AMBITOS', ['only' => ['destroy']]);
    }

    public function index()
    {



        /**
         * Enfocada a completar los cuadros de programa e institucion con frentes etrategicos
         */
        $proceso = Proceso::where('PK_PCS_Id', '=', session()->get('id_proceso'))->first();
        $programa = $proceso->programa;
        $facultad = $proceso->programa->facultad;
        $sede = $proceso->programa->sede;
        $institucion = $proceso->programa->sede->institucion;
        $metodologia = $proceso->programa->metodologia;
        $metodologia_query = Metodologia::where('PK_MTD_Id', '=', $institucion->FK_ITN_Metodologia)->first();
        $frentesEstrategicos = FrenteEstrategico::where('FK_FES_Institucion', '=', $institucion->PK_ITN_Id)->get();
        // dd($proceso, $programa, $facultad, $sede, $institucion, $metodologia, $metodologia_query, $frentesEstrategicos);

        /**
         * Path para descargar
         */
        // $ruta = public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx";
        // dd(public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx");

        $documento = new TemplateProcessor('Plantila_AutoEvaluacion_V2.docx');

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
            // dd($lista);
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

            // dd($labelsCaracteristica, $dataCaracteristicas, $ponderacion, $contador_caracteristicas, $contador_factores);

            if($ponderacion >= 0 && $ponderacion <= 4){
                $documento->setValue('tipo1_'.$j, "X");
                $documento->setValue('tipo2_'.$j, " ");
                $documento->setValue('tipo3_'.$j, " ");
            }
            elseif($ponderacion > 4 && $ponderacion <= 7){
                $documento->setValue('tipo1_'.$j, " ");
                $documento->setValue('tipo2_'.$j, "X");
                $documento->setValue('tipo3_'.$j, " ");
            }
            elseif($ponderacion > 7 && $ponderacion <= 10){
                $documento->setValue('tipo1_'.$j, " ");
                $documento->setValue('tipo2_'.$j, " ");
                $documento->setValue('tipo3_'.$j, "X");
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
                $coberturaDocentes = ($encuestados[$l]->cantidad * 100) / 12;
            }
            elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVOS ACADEMICOS") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVO ACADEMICO") == 0
            || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "administrativo") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "administrativos") == 0){
                if(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVOS ACADEMICOS") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "DIRECTIVO ACADEMICO") == 0){
                    $totalDirectivo = $totalDirectivo + $encuestados[$l]->cantidad;
                    $coberturaDirectivo = $encuestados[$l]->cantidad * 100 / 8;
                }
                else{
                    $totalAdmin = $totalAdmin + $encuestados[$l]->cantidad;
                    $coberturaAdmin = $encuestados[$l]->cantidad * 100 / 10;
                }
                $totalAdmin_Directivo = $totalDirectivo + $totalAdmin;
                $coberturaAdmin_Directivo = $coberturaDirectivo + $coberturaAdmin;
            }
            elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "graduados") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "egresados") == 0){
                $totalEgresados = $totalEgresados + $encuestados[$l]->cantidad;
                $coberturaEgresados = ($encuestados[$l]->cantidad * 100 / 439);
            }
            elseif(strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "empresarios") == 0 || strcasecmp($encuestados[$l]->grupos->GIT_Nombre, "empleadores") == 0){
                $totalEmpresa = $totalEmpresa + $encuestados[$l]->cantidad;
                $coberturaEmpresa = ($encuestados[$l]->cantidad * 100 / 10);
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

        {
            // $totalPonderaciones_0 = 0;
            // $contPonderaciones_0 = 0;
            // $totalPonderaciones_1 = 0;
            // $contPonderaciones_1 = 0;
            // $totalPonderaciones_2 = 0;
            // $contPonderaciones_2 = 0;
            // $totalPonderaciones_3 = 0;
            // $contPonderaciones_3 = 0;
            // $totalPonderaciones_4 = 0;
            // $contPonderaciones_4 = 0;
            // $totalPonderaciones_5 = 0;
            // $contPonderaciones_5 = 0;
            // $totalPonderaciones_6 = 0;
            // $contPonderaciones_6 = 0;
            // $totalPonderaciones_7 = 0;
            // $contPonderaciones_7 = 0;
            // $totalPonderaciones_8 = 0;
            // $contPonderaciones_8 = 0;
            // $totalPonderaciones_9 = 0;
            // $contPonderaciones_9 = 0;
        }

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
                    {
                        // for($i = 0; $i < count($totalGruposI); $i++){
                        //     if($totalGruposI[$i]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre){
                        //         $totalPonderacion = $totalPonderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        //         array_push($grupoPonderacion, $totalGruposI[$i]->GIT_Nombre, $totalPonderacion);
                        //         $contPonderaciones[$i] ++;
                        //     }
                        // }
                    }
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
                {
                    // if($totalPonderaciones[0] != 0) {
                    //     $ponderacion[0] = $totalPonderaciones[0] / $contPonderaciones[0];
                    // }
                    // if($totalPonderaciones_1 != 0) {
                    //     $ponderacion_1 = $totalPonderaciones_1 / $contPonderaciones_1;
                    // }
                    // if($totalPonderaciones_2 != 0) {
                    //     $ponderacion_2 = $totalPonderaciones_2 / $contPonderaciones_2;
                    // }
                    // if($totalPonderaciones_3 != 0) {
                    //     $ponderacion_3 = $totalPonderaciones_3 / $contPonderaciones_3;
                    // }
                    // if($totalPonderaciones_4 != 0) {
                    //     $ponderacion_4 = $totalPonderaciones_4 / $contPonderaciones_4;
                    // }
                    // if($totalPonderaciones_5 != 0) {
                    //     $ponderacion_5 = $totalPonderaciones_5 / $contPonderaciones_5;
                    // }
                    // if($totalPonderaciones_6 != 0) {
                    //     $ponderacion_6 = $totalPonderaciones_6 / $contPonderaciones_6;
                    // }
                    // if($totalPonderaciones_7 != 0) {
                    //     $ponderacion_7 = $totalPonderaciones_7 / $contPonderaciones_7;
                    // }
                    // if($totalPonderaciones_8 != 0) {
                    //     $ponderacion_8 = $totalPonderaciones_8 / $contPonderaciones_8;
                    // }
                    // if($totalPonderaciones_9 != 0) {
                    //     $ponderacion_9 = $totalPonderaciones_9 / $contPonderaciones_9;
                    // }
                }
                for($l = 0; $l < count($totalGruposI); $l++){
                    if(!isset($labelGrupoInteres[$l])) {
                        $labelGrupoInteres[$l] = 0;
                    }
                    if(!isset($ponderacion[$l]) || $ponderacion[$l] == 0) {
                        $ponderacion[$l] = 0;
                    }
                }
                {
                    // if(!isset($labelGrupoInteres[0])) {
                    //     $labelGrupoInteres[0] = 0;
                    // }
                    // if(!isset($ponderacion[0])) {
                    //     $ponderacion[0] = 0;
                    // }
                    // if(!isset($labelGrupoInteres_1)) {
                    //     $labelGrupoInteres_1 = 0;
                    // }
                    // if(!isset($ponderacion_1)) {
                    //     $ponderacion_1 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_2)) {
                    //     $labelGrupoInteres_2 = 0;
                    // }
                    // if(!isset($ponderacion_2)) {
                    //     $ponderacion_2 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_3)) {
                    //     $labelGrupoInteres_3 = 0;
                    // }
                    // if(!isset($ponderacion_3)) {
                    //     $ponderacion_3 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_4)) {
                    //     $labelGrupoInteres_4 = 0;
                    // }
                    // if(!isset($ponderacion_4)) {
                    //     $ponderacion_4 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_5)) {
                    //     $labelGrupoInteres_5 = 0;
                    // }
                    // if(!isset($ponderacion_5)) {
                    //     $ponderacion_5 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_6)) {
                    //     $labelGrupoInteres_6 = 0;
                    // }
                    // if(!isset($ponderacion_6)) {
                    //     $ponderacion_6 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_7)) {
                    //     $labelGrupoInteres_7 = 0;
                    // }
                    // if(!isset($ponderacion_7)) {
                    //     $ponderacion_7 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_8)) {
                    //     $labelGrupoInteres_8 = 0;
                    // }
                    // if(!isset($ponderacion_8)) {
                    //     $ponderacion_8 = 0;
                    // }
                    // if(!isset($labelGrupoInteres_9)) {
                    //     $labelGrupoInteres_9 = 0;
                    // }
                    // if(!isset($ponderacion_9)) {
                    //     $ponderacion_9 = 0;
                    // }
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

        {
            // for($i = 0; $i < count($totalGruposI); $i++){
            //     $suma = 0;
            //     for($j = 0; $j < count($grupoFactores[1]); $j++){
            //         $suma = $suma + $grupoFactores[1][$j][$i];
            //         {
            //             // $grupoFactores[1][1][$i] +
            //             // $grupoFactores[1][2][$i] +
            //             // $grupoFactores[1][3][$i] +
            //             // $grupoFactores[1][4][$i] +
            //             // $grupoFactores[1][5][$i] +
            //             // $grupoFactores[1][6][$i];
            //         }
            //     }
            //     if($suma == 0){
            //         array_push($sumaPorFactor_1, 0);
            //     }
            //     else
            //     {
            //         array_push( $sumaPorFactor_1, ( ($suma / count($grupoFactores[1]))) * 10);
            //     }
            // }

            // for($i = 0; $i < count($totalGruposI); $i++){
            //     $suma = 0;
            //     for($j = 0; $j < count($grupoFactores[2]); $j++){
            //         $suma = $suma + $grupoFactores[2][$j][$i];
            //         {
            //             // $suma = $grupoFactores[2][0][$i] +
            //             //         $grupoFactores[2][1][$i] +
            //             //         $grupoFactores[2][2][$i] +
            //             //         $grupoFactores[2][3][$i] +
            //             //         $grupoFactores[2][4][$i] +
            //             //         $grupoFactores[2][5][$i] +
            //             //         $grupoFactores[2][6][$i] +
            //             //         $grupoFactores[2][7][$i] +
            //             //         $grupoFactores[2][8][$i] +
            //             //         $grupoFactores[2][9][$i] +
            //             //         $grupoFactores[2][10][$i] +
            //             //         $grupoFactores[2][11][$i] +
            //             //         $grupoFactores[2][12][$i] +
            //             //         $grupoFactores[2][13][$i] +
            //             //         $grupoFactores[2][14][$i];
            //         }
            //     }
            //     if($suma == 0){
            //         array_push($sumaPorFactor_2, 0);
            //     }
            //     else{
            //         array_push( $sumaPorFactor_2, ( ($suma / count($grupoFactores[2]))) * 10 );
            //     }
            // }

            // for($i = 0; $i < count($totalGruposI); $i++){
            //     $suma = 0;
            //     for($j = 0; $j < count($grupoFactores[3]); $j++){
            //         $suma = $suma + $grupoFactores[3][$j][$i];
            //         {
            //             // $suma = $grupoFactores[3][0][$i] +
            //             //         $grupoFactores[3][1][$i] +
            //             //         $grupoFactores[3][2][$i] +
            //             //         $grupoFactores[3][3][$i] +
            //             //         $grupoFactores[3][4][$i] +
            //             //         $grupoFactores[3][5][$i] +
            //             //         $grupoFactores[3][6][$i] +
            //             //         $grupoFactores[3][7][$i] +
            //             //         $grupoFactores[3][8][$i] +
            //             //         $grupoFactores[3][9][$i] +
            //             //         $grupoFactores[3][10][$i] +
            //             //         $grupoFactores[3][11][$i] +
            //             //         $grupoFactores[3][12][$i] +
            //             //         $grupoFactores[3][13][$i] +
            //             //         $grupoFactores[3][14][$i] +
            //             //         $grupoFactores[3][15][$i] +
            //             //         $grupoFactores[3][16][$i] +
            //             //         $grupoFactores[3][17][$i] +
            //             //         $grupoFactores[3][18][$i] +
            //             //         $grupoFactores[3][19][$i] +
            //             //         $grupoFactores[3][20][$i] +
            //             //         $grupoFactores[3][21][$i] +
            //             //         $grupoFactores[3][22][$i] +
            //             //         $grupoFactores[3][23][$i] +
            //             //         $grupoFactores[3][24][$i] +
            //             //         $grupoFactores[3][25][$i];
            //         }
            //     }
            //     if($suma == 0){
            //         array_push($sumaPorFactor_3, 0 );
            //     }
            //     else{
            //         array_push($sumaPorFactor_3, ( ($suma / 26)) * 10 );
            //     }
            // }

            // for($i = 0; $i < count($totalGruposI); $i++){
            //     $suma = 0;
            //     for($j = 0; $j < count($grupoFactores[4]); $j++){
            //         $suma = $suma + $grupoFactores[4][$j][$i];
            //         {
            //             // $suma = $grupoFactores[4][0][$i] +
            //             //         $grupoFactores[4][1][$i] +
            //             //         $grupoFactores[4][2][$i] +
            //             //         $grupoFactores[4][3][$i] +
            //             //         $grupoFactores[4][4][$i] +
            //             //         $grupoFactores[4][5][$i] +
            //             //         $grupoFactores[4][6][$i] +
            //             //         $grupoFactores[4][7][$i] +
            //             //         $grupoFactores[4][8][$i] +
            //             //         $grupoFactores[4][9][$i] +
            //             //         $grupoFactores[4][10][$i] +
            //             //         $grupoFactores[4][11][$i] +
            //             //         $grupoFactores[4][12][$i] +
            //             //         $grupoFactores[4][13][$i] +
            //             //         $grupoFactores[4][14][$i] +
            //             //         $grupoFactores[4][15][$i] +
            //             //         $grupoFactores[4][16][$i] +
            //             //         $grupoFactores[4][17][$i] +
            //             //         $grupoFactores[4][18][$i] +
            //             //         $grupoFactores[4][19][$i] +
            //             //         $grupoFactores[4][20][$i] +
            //             //         $grupoFactores[4][21][$i] +
            //             //         $grupoFactores[4][22][$i] +
            //             //         $grupoFactores[4][23][$i] +
            //             //         $grupoFactores[4][24][$i] +
            //             //         $grupoFactores[4][25][$i] +
            //             //         $grupoFactores[4][26][$i] +
            //             //         $grupoFactores[4][27][$i];
            //         }
            //     }
            //     if($suma == 0){
            //         array_push($sumaPorFactor_4, 0 );
            //     }
            //     else{
            //         array_push($sumaPorFactor_4, ( ($suma / 28)) * 10 );
            //     }
            // }
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

        // dd($consolidaciones);

        for($i = 0;$i < count($grupoFactores); $i++){
            $valida = $i + 1;
            // dd($valida);
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

        $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
            return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso'));
        })
            ->with('Caracteristicas.factor', 'responsable.usuarios', 'responsable.cargo')
            ->get();

        $documento->cloneRow('actFac', count($actividades));
        for($i = 0;$i < count($actividades); $i++){
            $lista = $i + 1;
            $documento->setValue('actFac#'.$lista, $actividades[$i]->Caracteristicas->factor->FCT_Identificador);
            $documento->setValue('actAc#'.$lista, "");
            $documento->setValue('actNom#'.$lista, $actividades[$i]->ACM_Nombre);
            $documento->setValue('actFi#'.$lista, $actividades[$i]->ACM_Fecha_Inicio);
            $documento->setValue('actFf#'.$lista, $actividades[$i]->ACM_Fecha_Fin);
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

        for($i = 0; $i < count($grupoFactores); $i ++){
            $identificador = $i + 1;
            for($j = 0; $j < count($calificaciones); $j ++){
                if($calificaciones[$j]->actividadesMejoramiento->Caracteristicas->factor->FCT_Identificador == $identificador){
                    $documento->setValue('accion_implementada#'.$i, $calificaciones[$j]->actividadesMejoramiento->ACM_Nombre);
                    $documento->setValue('seguimiento#'.$i, $calificaciones[$j]->actividadesMejoramiento->ACM_Descripcion);
                }
            break;
            }
        }


        $documento->saveAs('InformeAuto.docx');


//         $pathToFile = public_path(). "\InformeAuto.docx";
// // dd($pathToFile);
//         return response()->download($pathToFile);



        //
        return view('autoevaluacion.SuperAdministrador.Ambito.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $ambito = AmbitoResponsabilidad::all();
            return Datatables::of($ambito)
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ambito = new AmbitoResponsabilidad();
        $ambito->fill($request->only(['AMB_Nombre']));
        $ambito->save();

        return response(['msg' => 'Ambito registrado correctamente.',
            'title' => '¡Registro exitoso!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ambito = AmbitoResponsabilidad::find($id);
        $ambito->fill($request->only(['AMB_Nombre']));
        $ambito->update();
        return response(['msg' => 'El Ambito ha sido modificado exitosamente.',
            'title' => '¡Ambito modificado :*!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AmbitoResponsabilidad::destroy($id);

        return response(['msg' => 'El Ambito ha sido eliminado exitosamente.',
            'title' => '¡Ambito Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
