<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\SedesRequest;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Institucion;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\SolucionEncuesta;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_SEDES');
        $this->middleware(['permission:MODIFICAR_SEDES', 'permission:VER_SEDES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_SEDES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_SEDES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $labelsCaracteristica = [];
        $grupoPonderacion = [];
        $datosResultado = [];
        $grupoInterior = [];
        $grupoFactores = [];

        $labelCaracteristica = [];
        $totalPonderaciones = [];
        $contPonderaciones = [];

        $prueba = [];

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

        //Esto en teoria ira abajo, antes del for y despues de los contadores
        $totalGruposI = GrupoInteres::all();
        //

        /**
         * Inicializar el array para poder guardar las ponderaciones
         */
        for($i = 0; $i < count($totalGruposI); $i++){
            array_push($labelCaracteristica, "");
            array_push($totalPonderaciones, 0);
            array_push($contPonderaciones, 0);
            array_push($prueba, 0);
        }

        $contador_caracteristicas = 0;  //3     7       14
        $contador_factores = 0;         //1     2       3
            // $j = 0;                     //0     1       2
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
                    ->with('encuestados.grupos')
                    ->get();
                $totalPonderacion = 0;
                // $prueba = $soluciones->count();
                foreach ($soluciones as $solucion) {

                    // for($i = 0; $i < count($totalGruposI); $i++){
                    //     if($totalGruposI[$i]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre){
                    //         $totalPonderacion = $totalPonderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                    //         array_push($grupoPonderacion, $totalGruposI[$i]->GIT_Nombre, $totalPonderacion);
                    //         $contPonderaciones[$i] ++;
                    //     }
                    // }

                    if($totalGruposI[0]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[0] = $totalPonderaciones[0] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[0] = $totalGruposI[0]->GIT_Nombre;
                        $contPonderaciones[0] ++ ;
                    }
                    elseif($totalGruposI[1]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[1] = $totalPonderaciones[1] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[1] = $totalGruposI[1]->GIT_Nombre;
                        $contPonderaciones[1] ++ ;
                    }
                    elseif($totalGruposI[2]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[2] = $totalPonderaciones[2] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[2] = $totalGruposI[2]->GIT_Nombre;
                        $contPonderaciones[2] ++ ;
                    }
                    elseif($totalGruposI[3]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[3] = $totalPonderaciones[3] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[3] = $totalGruposI[3]->GIT_Nombre;
                        $contPonderaciones[3] ++ ;
                    }
                    elseif($totalGruposI[4]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[4] = $totalPonderaciones[4] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[4] = $totalGruposI[4]->GIT_Nombre;
                        $contPonderaciones[4] ++ ;
                    }
                    elseif($totalGruposI[5]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[5] = $totalPonderaciones[5] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[5] = $totalGruposI[5]->GIT_Nombre;
                        $contPonderaciones[5] ++ ;
                    }
                    elseif($totalGruposI[6]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[6] = $totalPonderaciones[6] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[6] = $totalGruposI[6]->GIT_Nombre;
                        $contPonderaciones[6] ++ ;
                    }
                    elseif($totalGruposI[7]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[7] = $totalPonderaciones[7] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[7] = $totalGruposI[7]->GIT_Nombre;
                        $contPonderaciones[7] ++ ;
                    }
                    elseif($totalGruposI[8]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[8]= $totalPonderaciones[8] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[8] = $totalGruposI[8]->GIT_Nombre;
                        $contPonderaciones[8] ++ ;
                    }
                    elseif($totalGruposI[9]->GIT_Nombre == $solucion->encuestados->grupos->GIT_Nombre) {
                        $totalPonderaciones[9] = $totalPonderaciones[9] + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                        $labelCaracteristica[9] = $totalGruposI[9]->GIT_Nombre;
                        $contPonderaciones[9] ++ ;
                    }

                }

                for($k = 0; $k < count($totalGruposI); $k++){
                    if($totalPonderaciones[$k] != 0) {
                        $prueba[$k] = $totalPonderaciones[$k] / $contPonderaciones[$k];
                    }
                }
                {
                    // if($totalPonderaciones[0] != 0) {
                    //     $prueba[0] = $totalPonderaciones[0] / $contPonderaciones[0];
                    // }
                    // if($totalPonderaciones_1 != 0) {
                    //     $prueba_1 = $totalPonderaciones_1 / $contPonderaciones_1;
                    // }
                    // if($totalPonderaciones_2 != 0) {
                    //     $prueba_2 = $totalPonderaciones_2 / $contPonderaciones_2;
                    // }
                    // if($totalPonderaciones_3 != 0) {
                    //     $prueba_3 = $totalPonderaciones_3 / $contPonderaciones_3;
                    // }
                    // if($totalPonderaciones_4 != 0) {
                    //     $prueba_4 = $totalPonderaciones_4 / $contPonderaciones_4;
                    // }
                    // if($totalPonderaciones_5 != 0) {
                    //     $prueba_5 = $totalPonderaciones_5 / $contPonderaciones_5;
                    // }
                    // if($totalPonderaciones_6 != 0) {
                    //     $prueba_6 = $totalPonderaciones_6 / $contPonderaciones_6;
                    // }
                    // if($totalPonderaciones_7 != 0) {
                    //     $prueba_7 = $totalPonderaciones_7 / $contPonderaciones_7;
                    // }
                    // if($totalPonderaciones_8 != 0) {
                    //     $prueba_8 = $totalPonderaciones_8 / $contPonderaciones_8;
                    // }
                    // if($totalPonderaciones_9 != 0) {
                    //     $prueba_9 = $totalPonderaciones_9 / $contPonderaciones_9;
                    // }
                }
                for($l = 0; $l < count($totalGruposI); $l++){
                    if(!isset($labelCaracteristica[$l])) {
                        $labelCaracteristica[$l] = "";
                    }
                    if(!isset($prueba[$l]) || $prueba[$l] == 0) {
                        $prueba[$l] = "";
                    }
                }
                {
                    // if(!isset($labelCaracteristica[0])) {
                    //     $labelCaracteristica[0] = 0;
                    // }
                    // if(!isset($prueba[0])) {
                    //     $prueba[0] = 0;
                    // }
                    // if(!isset($labelCaracteristica_1)) {
                    //     $labelCaracteristica_1 = 0;
                    // }
                    // if(!isset($prueba_1)) {
                    //     $prueba_1 = 0;
                    // }
                    // if(!isset($labelCaracteristica_2)) {
                    //     $labelCaracteristica_2 = 0;
                    // }
                    // if(!isset($prueba_2)) {
                    //     $prueba_2 = 0;
                    // }
                    // if(!isset($labelCaracteristica_3)) {
                    //     $labelCaracteristica_3 = 0;
                    // }
                    // if(!isset($prueba_3)) {
                    //     $prueba_3 = 0;
                    // }
                    // if(!isset($labelCaracteristica_4)) {
                    //     $labelCaracteristica_4 = 0;
                    // }
                    // if(!isset($prueba_4)) {
                    //     $prueba_4 = 0;
                    // }
                    // if(!isset($labelCaracteristica_5)) {
                    //     $labelCaracteristica_5 = 0;
                    // }
                    // if(!isset($prueba_5)) {
                    //     $prueba_5 = 0;
                    // }
                    // if(!isset($labelCaracteristica_6)) {
                    //     $labelCaracteristica_6 = 0;
                    // }
                    // if(!isset($prueba_6)) {
                    //     $prueba_6 = 0;
                    // }
                    // if(!isset($labelCaracteristica_7)) {
                    //     $labelCaracteristica_7 = 0;
                    // }
                    // if(!isset($prueba_7)) {
                    //     $prueba_7 = 0;
                    // }
                    // if(!isset($labelCaracteristica_8)) {
                    //     $labelCaracteristica_8 = 0;
                    // }
                    // if(!isset($prueba_8)) {
                    //     $prueba_8 = 0;
                    // }
                    // if(!isset($labelCaracteristica_9)) {
                    //     $labelCaracteristica_9 = 0;
                    // }
                    // if(!isset($prueba_9)) {
                    //     $prueba_9 = 0;
                    // }
                }


                array_push($datosResultado,         $labelCaracteristica[0], $prueba[0],
                                                    $labelCaracteristica[1], $prueba[1],
                                                    $labelCaracteristica[2], $prueba[2],
                                                    $labelCaracteristica[3], $prueba[3],
                                                    $labelCaracteristica[4], $prueba[4],
                                                    $labelCaracteristica[5], $prueba[5],
                                                    $labelCaracteristica[6], $prueba[6],
                                                    $labelCaracteristica[7], $prueba[7],
                                                    $labelCaracteristica[8], $prueba[8],
                                                    $labelCaracteristica[9], $prueba[9]
                                                );
                array_push($grupoInterior, $datosResultado);

                unset($datosResultado);
                $datosResultado = [];

            }//foreach caracteristicas

            array_push($grupoFactores, $grupoInterior);

            unset($datosResultado);
            $datosResultado = [];
        }   //FOR

        dd($grupoFactores);


        $instituciones = Institucion::pluck('ITN_Nombre', 'PK_ITN_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.Sedes.index', compact('estados', 'instituciones'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable todas las sedes
     */
    public function data(Request $request)
    {
        // if ($request->ajax() && $request->isMethod('GET')) {
        //     $sedes = Sede::with('estado')->get();
        //     // $sedes = Sede::with('institucion')->get();
        //     \Debugbar::info($sedes);
        //     return Datatables::of($sedes)
        //         ->make(true);

        // }
        if ($request->ajax() && $request->isMethod('GET')) {
            $sedes = Sede::with(['estado' => function ($query) {
                    return $query->select('PK_ESD_Id', 'ESD_Nombre');
                }])
                ->with(['institucion' => function($query){
                    return $query->select('PK_ITN_Id', 'ITN_Nombre');
                }])->get();
            return DataTables::of($sedes)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea las sedes
     */
    public function store(SedesRequest $request)
    {
        $sede = new Sede();
        $sede->fill($request->only(['SDS_Nombre', 'SDS_Descripcion']));
        $sede->FK_SDS_Institucion = $request->get('ITN_Nombre');
        $sede->FK_SDS_Estado = $request->get('PK_ESD_Id');
        \Debugbar::info($sede);
        $sede->save();

        return response([
            'msg' => 'Sede registrada correctamente.',
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion modifica las sedes
     */
    public function update(SedesRequest $request, $id)
    {
        $sede = Sede::findOrFail($id);
        $sede->fill($request->only(['SDS_Nombre', 'SDS_Descripcion']));
        $sede->FK_SDS_Estado = $request->get('PK_ESD_Id');
        $sede->FK_SDS_Institucion = $request->get('ITN_Nombre');
        $sede->update();
        return response([
            'msg' => 'La sede ha sido modificada exitosamente.',
            'title' => 'Sede Modificada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion elimina las sedes
     */
    public function destroy($id)
    {
        $sede = Sede::findOrFail($id);
        $sede->delete();

        return response([
            'msg' => 'La sede ha sido eliminada exitosamente.',
            'title' => '¡Sede Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
