<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\SolucionEncuesta;
use DataTables;
use Illuminate\Http\Request;

class CaracteristicasMejoramientoController extends Controller
{
    /**
     * Display a listing of the resource.
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
        $this->middleware('permission:ACCEDER_VALORIZACION_CARACTERISTICAS')->except('show');
        $this->middleware(['permission:VER_VALORIZACION_CARACTERISTICAS'], ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        return view('autoevaluacion.SuperAdministrador.CaracteristicasMejoramiento.index', compact('planMejoramiento'));
    }

    public function data(Request $request)
    {
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso', '=', session()->get('id_proceso'))
            ->first();
        if ($planMejoramiento != null) {
            if ($request->ajax() && $request->isMethod('GET')) {
                $proceso = Proceso::where('PK_PCS_Id', '=', session()->get('id_proceso'))
                    ->first();
                $caracteristicas = Caracteristica::whereHas('factor', function ($query) use ($proceso) {
                    return $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento);
                })
                    ->with('factor', 'ambitoResponsabilidad')
                    ->get();
                return DataTables::of($caracteristicas)
                    ->addColumn('Ambito', function ($caracteristicas) {
                        if ($caracteristicas->ambitoResponsabilidad) {
                            return $caracteristicas->ambitoResponsabilidad->AMB_Nombre;
                        } else {
                            return "No tiene asociado un Ambito de Responsabilidad";
                        }
                    })
                    ->addColumn('Valorizacion', function ($caracteristicas) {
                        $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query) {
                            return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                        })
                            ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristicas) {
                                return $query->where('PK_CRT_Id', '=', $caracteristicas->PK_CRT_Id);
                            })
                            ->with('respuestas.ponderacion')
                            ->get();
                        if ($soluciones->count() > 0) {
                            $totalponderacion = 0;
                            $prueba = $soluciones->count();
                            foreach ($soluciones as $solucion) {
                                $totalponderacion = $totalponderacion + (10 / $solucion->respuestas->ponderacion->PRT_Rango);
                            }
                            session()->push('valorizacion', round($totalponderacion / $prueba), 2);
                            return round($totalponderacion / $prueba, 2);
                        } else {
                            session()->push('valorizacion', 0);
                            return 0;
                        }
                    })
                    ->addColumn('Calificacion', function ($caracteristicas) {
                        $valor = session()->pull('valorizacion')[0];
                        if ($valor >= 0.0 && $valor < 3.9) {
                            return "<span class='label label-sm label-danger'>No se cumple</span>";
                        } elseif ($valor >= 4.0 && $valor <= 6.9) {
                            return "<span class='label label-sm label-warning'>Parcialmente</span>";
                        } elseif ($valor >= 7.0 && $valor <= 9.5) {
                            return "<span class='label label-sm label-info'>Se cumple aceptablemente</span>";
                        } else {
                            return "<span class='label label-sm label-success'>Se cumple totalmente</span>";
                        }
                    })
                    ->rawColumns(['Calificacion'])
                    ->removeColumn('created_at')
                    ->removeColumn('updated_at')
                    ->make(true);
            }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
