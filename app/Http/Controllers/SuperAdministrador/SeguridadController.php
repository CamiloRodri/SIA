<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SeguridadController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCESO_SEGURIDAD');
    }
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Seguridad.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $seguridad = Activity::all();
            return DataTables::of($seguridad)
                ->removeColumn('updated_at')
                ->addColumn('tabla', function ($seguridad) {
                    return substr($seguridad->subject_type, 26);
                })
                ->addColumn('usuario', function ($seguridad) {
                    return $seguridad->causer->email ?? 'Usuario no especificado';
                })

                ->addColumn('antes', function ($seguridad) {
                    $json = json_decode($seguridad->properties, true);

                    if(isset($json['old'])){
                        $data = json_encode($json['old']);
                        return $data;
                    }

                    return '';
                })
                ->addColumn('despues', function ($seguridad) {
                    $json = json_decode($seguridad->properties, true);

                    if ($seguridad->description == 'deleted') {
                        return '';
                    }

                    if (isset($json['attributes'])) {
                        $data = json_encode($json['attributes']);
                        return $data;
                    }

                    return '';
                })
                ->rawColumns(['antes, despues'])
                ->make(true);
        }
    }
}
