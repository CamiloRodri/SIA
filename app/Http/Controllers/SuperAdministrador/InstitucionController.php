<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstitucionRequest;
use App\Models\Autoevaluacion\FrenteEstrategico;
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
        $this->middleware('permission:ASIGNAR_FRENTE_ESTRATEGICO_INSTITUCION')->except('show');
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
     * Esta funcion muestra en el datatable todas las instituciones
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $metodologias = Metodologia::pluck('MTD_Nombre', 'PK_MTD_Id');
        $frenteEstrategicos = [ '1','2','3','4','5','6','7','8'];
        return view('autoevaluacion.SuperAdministrador.Instituciones.create', 
                    compact('estados', 'metodologias','frenteEstrategicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitucionRequest $request)
    {
        
        $institucion = new Institucion();
        $institucion->ITN_Nombre = $request->get('ITN_Nombre');
        $institucion->ITN_Domicilio = $request->get('ITN_Domicilio');
        $institucion->ITN_Caracter = $request->get('ITN_Caracter');
        $institucion->ITN_CodigoSNIES = $request->get('ITN_CodigoSNIES');
        $institucion->ITN_Norma_Creacion = $request->get('ITN_Norma_Creacion');
        $institucion->ITN_Estudiantes = $request->get('ITN_Estudiantes');
        $institucion->ITN_Profesor_Planta = $request->get('ITN_Profesor_Planta');
        $institucion->ITN_Profesor_TCompleto = $request->get('ITN_Profesor_TCompleto');
        $institucion->ITN_Profesor_TMedio = $request->get('ITN_Profesor_TMedio');
        $institucion->ITN_Profesor_Catedra = $request->get('ITN_Profesor_Catedra');
        $institucion->ITN_Graduados = $request->get('ITN_Graduados');
        $institucion->ITN_Mision = $request->get('ITN_Mision');
        $institucion->ITN_Vision = $request->get('ITN_Vision');
        $institucion->ITN_FuenteBoletinMes = $request->get('ITN_FuenteBoletinMes');
        $institucion->ITN_FuenteBoletinAnio = $request->get('ITN_FuenteBoletinAnio');

        $institucion->FK_ITN_Estado = $request->get('FK_ITN_Estado');
        $institucion->FK_ITN_Metodologia = $request->get('FK_ITN_Metodologia');
        
        $institucion->save();

        $cantInstituciones = Institucion::count();

        for ($i = 1; $i <= $cantInstituciones; $i++) {
            $frenteEstrategico = new FrenteEstrategico();
            $frenteEstrategico->FES_Nombre = $request->get('Nombre_' . $i);
            $frenteEstrategico->FES_Descripcion = $request->get('Descripcion_' . $i);
            $frenteEstrategico->FK_FES_Institucion = $institucion->PK_ITN_Id;
            $frenteEstrategico->save();
        }
        return response(['msg' => 'Institución registrada correctamente.',
            'title' => '¡Registro exitoso!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     *  $id
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
        $institucion = Institucion::findOrFail($id);
        $metodologias = Metodologia::pluck('MTD_Nombre', 'PK_MTD_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        $frenteEstrategicos = FrenteEstrategico::where('FK_FES_Institucion', $id)->get();

        return view(
            'autoevaluacion.SuperAdministrador.Instituciones.edit',
            compact('institucion', 'metodologias', 'estados', 'frenteEstrategicos')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstitucionRequest $request, $id)
    {
        $institucion = Institucion::find($id);
        $institucion->ITN_Nombre = $request->get('FK_ITN_Estado');
        $institucion->ITN_Domicilio = $request->get('ITN_Domicilio');
        $institucion->ITN_Caracter = $request->get('ITN_Caracter');
        $institucion->ITN_CodigoSNIES = $request->get('ITN_CodigoSNIES');
        $institucion->ITN_Norma_Creacion = $request->get('ITN_Norma_Creacion');
        $institucion->ITN_Estudiantes = $request->get('ITN_Estudiantes');
        $institucion->ITN_Profesor_Planta = $request->get('ITN_Profesor_Planta');
        $institucion->ITN_Profesor_TCompleto = $request->get('ITN_Profesor_TCompleto');
        $institucion->ITN_Profesor_TMedio = $request->get('ITN_Profesor_TMedio');
        $institucion->ITN_Profesor_Catedra = $request->get('ITN_Profesor_Catedra');
        $institucion->ITN_Graduados = $request->get('ITN_Graduados');
        $institucion->ITN_Mision = $request->get('ITN_Mision');
        $institucion->ITN_Vision = $request->get('ITN_Vision');
        $institucion->ITN_FuenteBoletinMes = $request->get('ITN_FuenteBoletinMes');
        $institucion->ITN_FuenteBoletinAnio = $request->get('ITN_FuenteBoletinAnio');

        $institucion->FK_ITN_Estado = $request->get('FK_ITN_Estado');
        $institucion->FK_ITN_Metodologia = $request->get('FK_ITN_Metodologia');

        $institucion->update();

        $cantInstituciones = Institucion::count();

        for ($i = 1; $i <= $cantInstituciones; $i++) {
            $frenteEstrategicos = new FrenteEstrategico();
            $frenteEstrategicos->FES_Nombre = $request->get('PK_FES_Nombre');
            $frenteEstrategicos->FES_Descripcion = $request->get('PK_FES_Descripcion');
            // \Debugbar::info($frenteEstrategico->FES_Descripcion);
            // $frenteEstrategico->FK_FES_Institucion = $institucion->PK_ITN_Id;
            $frenteEstrategicos->update();
        }

        return response([
            'msg' => 'La Institución ha sido modificado exitosamente.',
            'title' => 'Institución Modificada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Institucion::destroy($id);

        return response([
            'msg' => 'La Institución ha sido eliminada exitosamente.',
            'title' => 'Institución Eliminada!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
