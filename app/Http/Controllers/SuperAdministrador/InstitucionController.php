<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Requests\InstitucionRequest;
use App\Models\Autoevaluacion\Institucion;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Metodologia;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_INSTITUCION')->except('show');
        $this->middleware(['permission:MODIFICAR_INSTITUCION', 'permission:VER_INSTITUCION'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_INSTITUCION', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_INSTITUCION', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $metodologias = Metodologia::pluck('MTD_Nombre', 'PK_MTD_Id');
        return view('autoevaluacion.SuperAdministrador.Instituciones.index', compact('estados', 'metodologias'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion muestra en el datatable todos los usuarios
     * depende de si eres administrador
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $institucion = Institucion::with(['estado' => function ($query) {
                    return $query->select('PK_ESD_Id', 'ESD_Nombre');
                }])
                ->with(['metodologia' => function($query){
                    return $query->select('PK_MTD_Id', 'MTD_Nombre');
                }])->get();
            return DataTables::of($institucion)
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
    /**
     * Esta funcion retorna de formulario crear
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
