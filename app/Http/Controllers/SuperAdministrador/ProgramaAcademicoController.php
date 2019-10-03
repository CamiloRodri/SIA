<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramasAcademicosRequest;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Sede;
use App\Models\Autoevaluacion\Institucion;
use App\Models\Autoevaluacion\Metodologia;
use Yajra\DataTables\DataTables;
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
                ->with(['metodologia' => function ($query) {
                    return $query->select('PK_MTD_Id', 'MTD_Nombre');
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
        $instituciones = Institucion::pluck('ITN_nombre', 'PK_ITN_Id');
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
        $metodologias = Metodologia::pluck('MTD_Nombre', 'PK_MTD_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.create',
            compact('sedes', 'facultades', 'estados', 'metodologias', 'instituciones')
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
        $programaAcademico->fill($request->only([   'PAC_Nombre', 'PAC_Nombre',
                                                    'PAC_Nivel_Formacion', 'PAC_Nivel_Formacion',
                                                    'PAC_Titutlo_Otorga', 'PAC_Titutlo_Otorga',
                                                    'PAC_Situacion_Programa', 'PAC_Situacion_Programa',
                                                    'PAC_Anio_Inicio_Actividades', 'PAC_Anio_Inicio_Actividades',
                                                    'PAC_Descripcion', 'PAC_Descripcion',
                                                    'PAC_Anio_Inicio_Programa', 'PAC_Anio_Inicio_Programa',
                                                    'PAC_Lugar_Funcionamiento', 'PAC_Lugar_Funcionamiento',
                                                    'PAC_Norma_Interna', 'PAC_Norma_Interna',
                                                    'PAC_Resolucion_Registro', 'PAC_Resolucion_Registro',
                                                    'PAC_Codigo_SNIES', 'PAC_Codigo_SNIES',
                                                    'PAC_Numero_Creditos', 'PAC_Numero_Creditos',
                                                    'PAC_Duracion', 'PAC_Duracion',
                                                    'PAC_Jornada', 'PAC_Jornada',
                                                    'PAC_Duracion_Semestre', 'PAC_Duracion_Semestre',
                                                    'PAC_Periodicidad', 'PAC_Periodicidad',
                                                    'PAC_Adscrito', 'PAC_Adscrito',
                                                    'PAC_Area_Conocimiento', 'PAC_Area_Conocimiento',
                                                    'PAC_Nucleo', 'PAC_Nucleo',
                                                    'PAC_Area_Formacion', 'PAC_Area_Formacion',
                                                    'PAC_Estudiantes', 'PAC_Estudiantes',
                                                    'PAC_Egresados', 'PAC_Egresados',
                                                    'PAC_Valor_Matricula', 'PAC_Valor_Matricula'
                                                ]));
        $programaAcademico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        $programaAcademico->FK_PAC_Estado = $request->get('PK_ESD_Id');
        $programaAcademico->FK_PAC_Facultad = $request->get('PK_FCD_Id');
        $programaAcademico->FK_PAC_Metodologia = $request->get('PK_MTD_Id');
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
        $sedes = Sede::where('FK_SDS_Institucion', $id)->get()->pluck('SDS_Nombre', 'PK_SDS_Id');
        return json_encode($sedes);
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
        $sede = Sede::findOrFail($programaAcademico->FK_PAC_Sede);
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
        $metodologias = Metodologia::pluck('MTD_Nombre', 'PK_MTD_Id');
        $instituciones = Institucion::pluck('ITN_nombre', 'PK_ITN_Id');
        $idInstitucion = $sede->FK_SDS_Institucion;

        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.edit',
            compact('programaAcademico', 'sedes', 'estados', 'facultades', 'metodologias', 'instituciones', 'idInstitucion')
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
        $programaAcademico->fill($request->only([   'PAC_Nombre', 'PAC_Nombre',
                                                    'PAC_Nivel_Formacion', 'PAC_Nivel_Formacion',
                                                    'PAC_Titutlo_Otorga', 'PAC_Titutlo_Otorga',
                                                    'PAC_Situacion_Programa', 'PAC_Situacion_Programa',
                                                    'PAC_Anio_Inicio_Actividades', 'PAC_Anio_Inicio_Actividades',
                                                    'PAC_Descripcion', 'PAC_Descripcion',
                                                    'PAC_Anio_Inicio_Programa', 'PAC_Anio_Inicio_Programa',
                                                    'PAC_Lugar_Funcionamiento', 'PAC_Lugar_Funcionamiento',
                                                    'PAC_Norma_Interna', 'PAC_Norma_Interna',
                                                    'PAC_Resolucion_Registro', 'PAC_Resolucion_Registro',
                                                    'PAC_Codigo_SNIES', 'PAC_Codigo_SNIES',
                                                    'PAC_Numero_Creditos', 'PAC_Numero_Creditos',
                                                    'PAC_Duracion', 'PAC_Duracion',
                                                    'PAC_Jornada', 'PAC_Jornada',
                                                    'PAC_Duracion_Semestre', 'PAC_Duracion_Semestre',
                                                    'PAC_Periodicidad', 'PAC_Periodicidad',
                                                    'PAC_Adscrito', 'PAC_Adscrito',
                                                    'PAC_Area_Conocimiento', 'PAC_Area_Conocimiento',
                                                    'PAC_Nucleo', 'PAC_Nucleo',
                                                    'PAC_Area_Formacion', 'PAC_Area_Formacion',
                                                    'PAC_Estudiantes', 'PAC_Estudiantes',
                                                    'PAC_Egresados', 'PAC_Egresados',
                                                    'PAC_Valor_Matricula', 'PAC_Valor_Matricula'
                                                ]));
        if($request->get('PK_SDS_Id') != ''){
            $programaAcademico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        }
        else{
            $programas = ProgramaAcademico::find($programaAcademico->PK_PAC_Id);
            $programaAcademico->FK_PAC_Sede = $programas->FK_PAC_Sede;
        } 
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

    public function institucion($id)
    {
        $instituciones = Institucion::where('FK_SDS_Institucion', $id)->get()
            ->pluck('SDS_Nombre', 'PK_SDS_Id');
        return json_encode($instituciones);
    }
}
