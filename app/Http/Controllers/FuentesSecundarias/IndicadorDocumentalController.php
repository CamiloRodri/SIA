<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndicadoresDocumentalesRequest;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Lineamiento;
use DataTables;
use Illuminate\Http\Request;


class IndicadorDocumentalController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_INDICADORES_DOCUMENTALES');
        $this->middleware(['permission:MODIFICAR_INDICADORES_DOCUMENTALES', 'permission:VER_INDICADORES_DOCUMENTALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_INDICADORES_DOCUMENTALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_INDICADORES_DOCUMENTALES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $indicadoresDocumentales = IndicadorDocumental::with('caracteristica.factor.lineamiento')
                ->with(['estado' => function ($query) {
                    return $query->select('PK_ESD_Id', 'ESD_Nombre');
                }])
                ->get();
            return DataTables::of($indicadoresDocumentales)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                /**
                 * SE agregan mutadores para obtener el identificador del factor, característica,
                 * indicador junto a su respectivo indicador
                 */
                ->addColumn('nombre_factor', function ($indicadoresDocumentales) {
                    return $indicadoresDocumentales->caracteristica->factor->nombre_factor;
                })
                ->addColumn('nombre_caracteristica', function ($indicadoresDocumentales) {
                    return $indicadoresDocumentales->caracteristica->nombre_caracteristica;
                })
                ->addColumn('nombre_indicador', function ($indicadoresDocumentales) {
                    return $indicadoresDocumentales->nombre_indicador;
                })
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
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        return view('autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.create',
            compact('lineamientos', 'estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndicadoresDocumentalesRequest $request)
    {
        $indicadorDocumental = new IndicadorDocumental();
        $indicadorDocumental->fill($request->only(['IDO_Nombre', 'IDO_Descripcion', 'IDO_Identificador']));
        $indicadorDocumental->FK_IDO_Caracteristica = $request->get('PK_CRT_Id');
        $indicadorDocumental->FK_IDO_Estado = $request->get('PK_ESD_Id');
        $indicadorDocumental->save();

        return response(['msg' => 'Indicador documental registrado correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        $indicadoresDocumentales = IndicadorDocumental::where('FK_IDO_Caracteristica', $id)
            ->get()
            ->pluck('nombre_indicador', 'PK_IDO_Id');
        return json_encode($indicadoresDocumentales);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indicador = IndicadorDocumental::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');

        $factor = new Factor();
        $idFactor = $indicador->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $idFactor)->get()->pluck('nombre_factor', 'PK_FCT_Id');

        $caracteristica = new Caracteristica();
        $idCaracteristica = $indicador->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $idCaracteristica)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        $uso = DocumentoAutoevaluacion::where('FK_DOA_IndicadorDocumental', '=', $id)->get()->count();

        return view(
            'autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.edit',
            compact('indicador', 'lineamientos', 'factores', 'caracteristicas', 'estados', 'uso')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IndicadoresDocumentalesRequest $request, $id)
    {
        $indicador = IndicadorDocumental::find($id);
        $indicador->fill($request->only(['IDO_Nombre', 'IDO_Descripcion', 'IDO_Identificador']));
        $indicador->FK_IDO_Caracteristica = $request->get('PK_CRT_Id');
        $indicador->FK_IDO_Estado = $request->get('PK_ESD_Id');


        $indicador->update();


        return response(['msg' => 'El Indicador documental ha sido modificado exitosamente.',
            'title' => 'Indicador Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        IndicadorDocumental::destroy($id);

        return response(['msg' => 'El Indicador documental ha sido eliminado exitosamente.',
            'title' => 'Indicador documental Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
