<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\FactoresRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Lineamiento;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FactorController extends Controller
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
        $this->middleware('permission:ACCEDER_FACTORES')->except('show');
        $this->middleware(['permission:MODIFICAR_FACTORES', 'permission:VER_FACTORES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_FACTORES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_FACTORES', ['only' => ['destroy']]);

    }

    /**
     * Esta funcion llena el datatable de factor y lineamientos
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $factores = Factor::with(['estado' => function ($query) {
                return $query->select('PK_ESD_Id', 'ESD_Nombre as nombre_estado');
            }])
                ->with(['lineamiento' => function ($query) {
                    return $query->select('PK_LNM_Id',
                        'LNM_Nombre as nombre');
                }])->get();
            return Datatables::of($factores)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addColumn('nombre_factor', function ($factores) {
                    return $factores->nombre_factor;
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Factor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion trae id y nombres de estados y lineamientos,
     * cuando se quiere registrar un nuevo factor
     */
    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        return view('autoevaluacion.SuperAdministrador.Factor.create', compact('estados', 'lineamientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion registra los factores
     */
    public function store(FactoresRequest $request)
    {
        Factor::create($request->all());
        return response(['msg' => 'Factor registrado correctamente.',
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
     * Esta funcion trae los factores del lineamiento
     */
    public function show($id)
    {
        $factores = Factor::where('FK_FCT_Lineamiento', $id)->get()->pluck('nombre_factor', 'PK_FCT_Id');
        return json_encode($factores);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        return view('autoevaluacion.SuperAdministrador.Factor.edit', [
            'user' => Factor::findOrFail($id),
            'edit' => true,
        ], compact('estados', 'lineamientos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion modifica el factor
     */
    public function update(FactoresRequest $request, $id)
    {
        $user = Factor::find($id);
        $user->fill($request->all());
        $user->save();
        return response(['msg' => 'EL factor ha sido modificado exitosamente.',
            'title' => 'Factor Modificado!',
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
     * Esta funcion elimina el factor
     */
    public function destroy($id)
    {
        Factor::destroy($id);

        return response(['msg' => 'El factor ha sido eliminado exitosamente.',
            'title' => 'Factor Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
