<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\BancoEncuestasRequest;
use App\Models\Autoevaluacion\BancoEncuestas;
use App\Models\Autoevaluacion\Encuesta;
use DataTables;
use Illuminate\Http\Request;


class BancoEncuestasController extends Controller
{
    /*
    Este controlador es responsable de manejar el banco de encuestas 
    almacenadas en el sistema que pueden ser aplicables a procesos de autoevaluacion 
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_BANCO_ENCUESTAS');
        $this->middleware(['permission:MODIFICAR_BANCO_ENCUESTAS', 'permission:VER_BANCO_ENCUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_BANCO_ENCUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_BANCO_ENCUESTAS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.BancoEncuestas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $bancoEncuestas = BancoEncuestas::all();
            return Datatables::of($bancoEncuestas)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
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
    public function store(BancoEncuestasRequest $request)
    {
        $bancoEncuestas = new BancoEncuestas();
        $bancoEncuestas->fill($request->only(['BEC_Nombre', 'BEC_Descripcion']));
        $bancoEncuestas->save();
        return response(['msg' => 'Datos de encuesta registrados correctamente.',
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BancoEncuestasRequest $request, $id)
    {
        $bancoEncuestas = BancoEncuestas::findOrFail($id);
        $bancoEncuestas->fill($request->only(['BEC_Nombre', 'BEC_Descripcion']));
        $bancoEncuestas->update();
        return response(['msg' => 'Los datos han sido modificados exitosamente.',
            'title' => 'Datos Modificados!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Para que el proceso de eliminacion de una encuesta sea exitoso, el sistema debe verificar si existe
     * algun proceso en fase de captura de datos, en el caso que se cumpla esta condicion no se permitira
     * eliminar la encuesta ya que esto afectaria el correcto desarrollo del proceso de autoevaluacion
     * en cuestion.
     */
    public function destroy($id)
    {
        $bancoEncuestas = BancoEncuestas::findOrFail($id);
        $encuestas = Encuesta::whereHas('proceso', function ($query) {
            return $query->where('FK_PCS_Fase', '=', '4');
        })
            ->where('FK_ECT_Banco_Encuestas', '=', $bancoEncuestas->PK_BEC_Id)
            ->get();
        if ($encuestas->count() == 0) {
            $bancoEncuestas->delete();
            return response(['msg' => 'La encuesta ha sido eliminada exitosamente.',
                'title' => 'Encuesta Eliminada!'
            ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        } else {
            return response([
                'errors' => ['La encuesta se encuentra relacionada a un proceso en estado de captura de datos'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
    }
}
