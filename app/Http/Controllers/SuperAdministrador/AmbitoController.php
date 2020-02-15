<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\FrenteEstrategico;
use App\Models\Autoevaluacion\Metodologia;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\SolucionEncuesta;
use DataTables;
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
        //


        /**
         * Enfocada a completar los cuadros de programa e institucion con frentes etrategicos
         */
        $proceso = Proceso::where('PK_PCS_Id', '=', session()->get('id_proceso'))->first();
        $programa = $proceso->programa;
        $facultad = $proceso->programa->facultad;
        $sede = $proceso->programa->sede;
        $institucion = $proceso->programa->sede->institucion;
        $metodologia = $proceso->programa->metodologia;
        // $metodologia_query = Metodologia::where('PK_MTD_Id', '=', $institucion->FK_ITN_Metodologia)->first();
        // $frentesEstrategicos = FrenteEstrategico::where('FK_FES_Institucion', '=', $institucion->PK_ITN_Id)->get();
        // dd($proceso, $programa, $facultad, $sede, $institucion, $metodologia, $metodologia_query, $frentesEstrategicos);

        // $ruta = public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx";
        // dd(public_path(). "\storage\Plantila_AutoEvaluacion_V2.docx");

        $documento = new TemplateProcessor('Plantila_AutoEvaluacion_V2.docx');

        // $documento->setValue('nombre_institucion', $institucion->ITN_Nombre);
        // $documento->setValue('domicilio_institucion', $institucion->ITN_Domicilio);
        // $documento->setValue('caracter_institucion', $institucion->ITN_Caracter);
        // $documento->setValue('snies_institucion', $institucion->ITN_CodigoSNIES);
        // $documento->setValue('norma_creacion', $institucion->ITN_Norma_Creacion);
        // $documento->setValue('estudiante_matriculados', $institucion->ITN_Estudiantes);
        // $documento->setValue('metodologia', $metodologia_query->MTD_Nombre);
        // $documento->setValue('planta', $institucion->ITN_Profesor_Planta);
        // $documento->setValue('t_c', $institucion->ITN_Profesor_TCompleto);
        // $documento->setValue('m_t', $institucion->ITN_Profesor_TMedio);
        // $documento->setValue('catedra', $institucion->ITN_Profesor_Catedra);
        // $documento->setValue('graduados', $institucion->ITN_Graduados);
        // $documento->setValue('boletin_mes', $institucion->ITN_FuenteBoletinMes);
        // $documento->setValue('boletin_anio', $institucion->ITN_FuenteBoletinAnio);
        // $documento->setValue('mision', $institucion->ITN_Mision);
        // $documento->setValue('vision', $institucion->ITN_Vision);
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

        // $documento->cloneRow('no_frente_estrategico', sizeof($frentesEstrategicos));

        /**
         * Uso de tablas
         */
        // $documento->setValue('no_frente_estrategico#1', 1);
        // $documento->setValue('no_frente_estrategico#2', 2);

        // for($i = 0; $i < sizeof($frentesEstrategicos); $i++) {
        //     $lista = $i + 1;
        //     // dd($lista);
        //     $documento->setValue('no_frente_estrategico#'.$lista, $lista);
        //     $documento->setValue('nombre_frente_estrategico#'.$lista, $frentesEstrategicos[$i]->FES_Nombre);
        //     $documento->setValue('descripcion_frente_estrategico#'.$lista, $frentesEstrategicos[$i]->FES_Descripcion);
        // }

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

            $documento->setValue('factor#'.$j, $factor->FCT_Nombre);

            for($k = 0; $k < sizeof($labelsCaracteristica); $k++) {
                $documento->setValue('caracteristica#'.$contador_caracteristicas, $labelsCaracteristica[$k]);
                $contador_caracteristicas++;
            }
            // $documento->setValue('caracteristica#'.$j, $labelsCaracteristica[0]);
            // $documento->setValue('caracteristica#'.$va1, $labelsCaracteristica[1]);
            // $documento->setValue('caracteristica#'.$va2, $labelsCaracteristica[2]);

            $ponderacion = intval(array_sum($dataCaracteristicas)/count($dataCaracteristicas));

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


        $documento->saveAs('InformeAuto.docx');

//         $pathToFile = public_path(). "\InformeAuto.docx";
// // dd($pathToFile);
//         return response()->download($pathToFile);




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
