<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use Carbon\Carbon;
use App\Models\Autoevaluacion\Responsable;
use Illuminate\Support\Facades\Auth;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('SUPERADMIN') || Auth::user()->hasRole('SUPERADMIN')){
            $actividades = ActividadesMejoramiento::where('ACM_Fecha_Fin', '<=', Carbon::now()->addDay(2))
                ->where('ACM_Fecha_Fin', '>=', Carbon::now())
                ->where('ACM_Estado','=','0')
                ->get();
        }
        else{
            $responsable = Responsable::where('FK_RPS_Responsable','=',Auth::user()->id)
            ->first();
            $actividades = ActividadesMejoramiento::where('ACM_Fecha_Fin', '<=', Carbon::now()->addDay(2))
                ->where('ACM_Fecha_Fin', '>=', Carbon::now())
                ->where('ACM_Estado','=','0')
                ->where('FK_ACM_Responsable','=',$responsable->PK_RPS_Id ?? null)
                ->get();
        }
        $datos['notificaciones'] = $actividades;
        return json_encode($datos);

    }
}