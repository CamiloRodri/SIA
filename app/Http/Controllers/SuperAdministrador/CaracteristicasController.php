<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaracteristicasRequest;
use App\Models\Autoevaluacion\AmbitoResponsabilidad;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Lineamiento;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CaracteristicasController extends Controller
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
        $this->middleware('permission:ACCEDER_CARACTERISTICAS')->except('show');
        $this->middleware(['permission:MODIFICAR_CARACTERISTICAS', 'permission:VER_CARACTERISTICAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_CARACTERISTICAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_CARACTERISTICAS', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion llena el datatable de caracteristica que esta ligado
     * a ambito y factor
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $caracteristicas = Caracteristica::with(['estado' => function ($query) {
                return $query->select('PK_ESD_Id', 'ESD_Nombre as nombre_estado');
            }])
                ->with(['ambitoresponsabilidad' => function ($query) {
                    return $query->select(
                        'PK_AMB_Id',
                        'AMB_Nombre as nombre'
                    );
                }])->with(['factor' => function ($query) {
                return $query->select(
                    'PK_FCT_Id',
                    'FCT_Nombre',
                    'FCT_Identificador'
                );
            }])
                ->get();
            return Datatables::of($caracteristicas)
                ->addColumn('ambito', function ($caracteristica) {
                    if ($caracteristica->ambito) {
                        return $caracteristica->ambito;
                    } else {
                        return "Ningún ambito seleccionado";
                    }
                })
                ->addColumn('nombre_factor', function ($caracteristica) {
                    return $caracteristica->factor->FCT_Identificador . '. ' . $caracteristica->factor->FCT_Nombre;
                })
                ->addColumn('nombre_caracteristica', function ($caracteristica) {
                    return $caracteristica->nombre_caracteristica;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Esta funcion llena los selects con ambito, los estados
     * y lineamientos
     */
    public function create()
    {
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ambitos = AmbitoResponsabilidad::pluck('AMB_Nombre', 'PK_AMB_Id');
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.create', compact('lineamientos', 'estados', 'ambitos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion registra la caracteristica
     */
    public function store(CaracteristicasRequest $request)
    {
        Caracteristica::create($request->except('FK_FCT_Lineamiento'));
        return response(['msg' => 'Datos registrados correctamente.',
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
    /**
     * Esta funcion obtiene las caracteristicas del factor
     */
    public function show($id)
    {
        $caracteristicas = Caracteristica::where('FK_CRT_Factor', $id)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion obtiene los id y nombres de cada ambito, estado, lineamiento
     * y factor que esta ligado al lineamiento
     */
    public function edit($id)
    {
        $caracteristica = Caracteristica::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ambitos = AmbitoResponsabilidad::pluck('AMB_Nombre', 'PK_AMB_Id');

        $factor = new Factor();
        $idFactor = $caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $idFactor)->get()->pluck('nombre_factor', 'PK_FCT_Id');

        return view('autoevaluacion.SuperAdministrador.Caracteristicas.edit', [
            'user' => Caracteristica::findOrFail($id),
            'edit' => true,
        ], compact('caracteristica', 'lineamientos', 'factores', 'estados', 'ambitos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion modifica las caraccteristicas
     */
    public function update(CaracteristicasRequest $request, $id)
    {
        $caracteristica = Caracteristica::find($id);
        $caracteristica->fill($request->except('FK_FCT_Lineamiento'));
        $caracteristica->save();
        return response(['msg' => 'Los datos han sido modificado exitosamente.',
            'title' => 'Datos Modificadoa!',
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
     * Esta funcion elimina las caraccteristicas
     */
    public function destroy($id)
    {
        Caracteristica::destroy($id);

        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
            'title' => 'Datos Eliminados!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Esta funcion obtiene los factores del lineamiento
     */
    public function factores($id)
    {
        $factores = Factor::where('FK_FCT_Lineamiento', $id)->get()->pluck('nombre_factor', 'PK_FCT_Id');
        return json_encode($factores);
    }
}
