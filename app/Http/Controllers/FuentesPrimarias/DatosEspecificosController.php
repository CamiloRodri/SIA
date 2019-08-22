<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;
use App\Models\Autoevaluacion\BancoEncuestas;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Estado;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatosEspecificosController extends Controller
{
    /*
    Este controlador es responsable de vincular las encuestas a procesos de autoevaluacion 
    */

    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicacion como los son:
     * Acceder, ver, crea, modificar, eliminar
     */

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ENCUESTAS');
        $this->middleware(['permission:MODIFICAR_ENCUESTAS', 'permission:VER_ENCUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ENCUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ENCUESTAS', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            /**
             * Obtiene todos los procesos de autoevaluacion asignados al usuario y a los cuales ya les fue
             * asignada una encuesta.
             */
            $encuesta = Auth::user()->procesos()
                ->with('programa.sede', 'encuestas.estado', 'encuestas.banco')
                ->whereHas('encuestas.estado')
                ->get();
            return Datatables::of($encuesta)
                ->addColumn('programa', function ($encuesta) {
                    /**
                     * Se verifica si los datos obtenidos de los procesos de autoevaluacion
                     * tienen relacion con un programa ya que los procesos institucionales tienen este campo nulo.
                     */
                    if ($encuesta->programa) {
                        return $encuesta->programa->PAC_Nombre;
                    } else {
                        return "Ningún Programa seleccionado";
                    }
                })
                /**
                 * Se verifica si los datos obtenidos de los procesos de autoevaluacion
                 * tienen relacion con un programa ya que los procesos institucionales tienen este campo nulo
                 * en el caso que se cumpla la condicion la sede tambien es un campo nulo.
                 */
                ->addColumn('sede', function ($encuesta) {
                    if ($encuesta->programa) {
                        return $encuesta->programa->sede->SDS_Nombre;
                    } else {
                        return "Ninguna sede seleccionada";
                    }
                })
                /**
                 * Se debe cambiar el formato de la fecha de publicacion y de finalizacion.
                 */
                ->editColumn('encuestas.ECT_FechaPublicacion', function ($encuestas) {
                    return $encuestas->encuestas->ECT_FechaPublicacion ? with(new Carbon($encuestas->encuestas->ECT_FechaPublicacion))->format('d/m/Y') : '';
                })
                ->editColumn('encuestas.ECT_FechaFinalizacion', function ($encuestas) {
                    return $encuestas->encuestas->ECT_FechaFinalizacion ? with(new Carbon($encuestas->encuestas->ECT_FechaFinalizacion))->format('d/m/Y') : '';
                })
                ->addColumn('estado', function ($encuesta) {
                    if (!$encuesta->encuestas->estado) {
                        return '';
                    } elseif (!strcmp($encuesta->encuestas->estado->ESD_Nombre, 'HABILITADO')) {
                        return "<span class='label label-sm label-success'>" . $encuesta->encuestas->estado->ESD_Nombre . "</span>";
                    } else {
                        return "<span class='label label-sm label-danger'>" . $encuesta->encuestas->estado->ESD_Nombre . "</span>";
                    }
                    return "<span class='label label-sm label-primary'>" . $encuesta->encuestas->estado->ESD_Nombre . "</span>";
                })
                ->rawColumns(['estado'])
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }

    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $encuestas = BancoEncuestas::pluck('BEC_Nombre', 'PK_BEC_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.create', compact('estados', 'encuestas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EncuestaRequest $request)
    {
        $encuesta = new Encuesta();
        /**
         * Se debe cambiar el formato de la fecha de publicacion y de finalizacion.
         */
        $encuesta->ECT_FechaPublicacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));;
        $encuesta->ECT_FechaFinalizacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));
        $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
        $encuesta->FK_ECT_Banco_Encuestas = $request->get('PK_BEC_Id');
        $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
        $encuesta->save();
        return response([
            'msg' => 'Encuesta vinculada exitosamente al proceso .',
            'title' => '¡Vinculación exitosa!'
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encuesta = Encuesta::findOrFail($id);
        $this->authorize('autorizar', $encuesta->FK_ECT_Proceso);
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $encuestas = BancoEncuestas::pluck('BEC_Nombre', 'PK_BEC_Id');
        return view(
            'autoevaluacion.FuentesPrimarias.DatosEspecificos.edit',
            compact('encuesta', 'estados', 'encuestas')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EncuestaRequest $request, $id)
    {
        $encuesta = Encuesta::find($id);
        /**
         * Se utiliza la Gate autorizar para verificar si el usuario tiene permisos
         * de actualizar los datos especificos de la encuesta, si no es asi lo redirige al home
         */
        $this->authorize('autorizar', $encuesta->FK_ECT_Proceso);
        /**
         * Se debe cambiar el formato de la fecha de publicacion y de finalizacion.
         */
        $encuesta->ECT_FechaPublicacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));;
        $encuesta->ECT_FechaFinalizacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));
        $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
        $encuesta->FK_ECT_Banco_Encuestas = $request->get('PK_BEC_Id');
        $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
        $encuesta->update();
        return response([
            'msg' => 'Datos especificos resgistrados correctamente.',
            'title' => '¡Registro exitoso!'
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
        $encuesta = Encuesta::find($id);
        /**
         * Se utiliza la Gate autorizar para verificar si el usuario tiene permisos
         * de eliminar o desvincular una encuesta para un proceso de autoevalucion,
         * si no es asi lo redirige al home
         */
        $this->authorize('autorizar', $encuesta->FK_ECT_Proceso);
        $encuesta->delete();
        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
            'title' => 'Datos Eliminados!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
