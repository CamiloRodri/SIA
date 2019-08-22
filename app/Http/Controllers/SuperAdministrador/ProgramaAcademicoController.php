<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramasAcademicosRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Sede;
use DataTables;
use Illuminate\Http\Request;

class ProgramaAcademicoController extends Controller
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
        $this->middleware('permission:ACCEDER_PROGRAMAS_ACADEMICOS');
        $this->middleware(['permission:MODIFICAR_PROGRAMAS_ACADEMICOS', 'permission:VER_PROGRAMAS_ACADEMICOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROGRAMAS_ACADEMICOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROGRAMAS_ACADEMICOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ProgramasAcademicos.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable los programas existentes
     * con sus sedes y facultades
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $programasAcademicos = ProgramaAcademico::with(['facultad' => function ($query) {
                return $query->select('PK_FCD_Id', 'FCD_Nombre');

            }])
                ->with(['sede' => function ($query) {
                    return $query->select('PK_SDS_Id', 'SDS_Nombre');
                }])
                ->with(['estado' => function ($query) {
                    return $query->select('PK_ESD_Id', 'ESD_Nombre');
                }])
                ->get();
            return DataTables::of($programasAcademicos)
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
     * Cuando se crea un programa es necessario una sede, facultad y estados
     * existentes
     */
    public function create()
    {
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.create',
            compact('sedes', 'facultades', 'estados')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los programas
     */
    public function store(ProgramasAcademicosRequest $request)
    {
        $programaAcademico = new ProgramaAcademico();
        $programaAcademico->fill($request->only(['PAC_Nombre', 'PAC_Descripcion']));
        $programaAcademico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        $programaAcademico->FK_PAC_Estado = $request->get('PK_ESD_Id');
        $programaAcademico->FK_PAC_Facultad = $request->get('PK_FCD_Id');
        $programaAcademico->save();

        return response([
            'msg' => 'Programa academico registrado correctamente.',
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
    /**
     *Cuando se edita un programa tambien se debe presentar su facultad, sede y estado
     */
    public function edit($id)
    {
        $programaAcademico = ProgramaAcademico::findOrFail($id);
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.edit',
            compact('programaAcademico', 'sedes', 'estados', 'facultades')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion edita los programas
     */
    public function update(ProgramasAcademicosRequest $request, $id)
    {
        $programaAcademico = ProgramaAcademico::find($id);
        $programaAcademico->fill($request->only(['PAC_Nombre', 'PAC_Descripcion']));
        $programaAcademico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        $programaAcademico->FK_PAC_Estado = $request->get('PK_ESD_Id');
        $programaAcademico->FK_PAC_Facultad = $request->get('PK_FCD_Id');

        $programaAcademico->update();

        return response([
            'msg' => 'El Programa academico ha sido modificado exitosamente.',
            'title' => 'Programa academico Modificado!',
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
     * Esta funcion elimina los programas academicos
     */
    public function destroy($id)
    {
        ProgramaAcademico::destroy($id);

        return response([
            'msg' => 'El programa academico ha sido eliminado exitosamente.',
            'title' => 'Programa academico Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
