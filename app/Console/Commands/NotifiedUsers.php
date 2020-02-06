<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Responsable;
use App\Models\Autoevaluacion\FechaCorte;
use App\Models\Autoevaluacion\CalificaActividad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection as Collection;

class NotifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notified:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo como notificación a los responsables de actividades por vencer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Esta es la logica empleada para el envio de notificaciones por correos
         */
        $act_msg = ActividadesMejoramiento::where('ACM_Estado', '!=', '2')->where('ACM_Estado', '!=', '3')->get();
        for($i = 0; $i < sizeof($act_msg); $i++ ) {
            $dias_restantes = $act_msg[$i]->ACM_Fecha_Fin->diffInDays(Carbon::now()) + 1;
            if(Carbon::now()->format('Y-m-d') != $act_msg[$i]->ACM_Notificacion && $act_msg[$i]->ACM_Fecha_Fin >= Carbon::now()->format('Y-m-d')) {
                if($dias_restantes >= 1 && $dias_restantes < 5 && Carbon::now()->format('Y-m-d') != $act_msg[$i]->ACM_Fecha_Fin) {
                    if($act_msg[$i]->ACM_Fecha_Fin->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
                        $dias_restantes_alert = "<span class='label danger'>¡Hoy ultimo plazo para cargar evidencia!</span>";
                    }
                    else{
                        $dias_restantes_alert = "<span class='label danger'>Tener en cuenta, días restantes: $dias_restantes</span>";
                    }
                    $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                    $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                    $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                    $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                    $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                    $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                    $to = $act_msg[$i]->correo_responsable;
                    $subject = "Acitividad de Mejoramiento [Notificación]";
                    $colletion = Collection::make($act_msg[$i]);
                    $info_mensaje = $colletion->toArray();

                    Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                        $message->from($to, $for);
                        $message->subject($subject);
                        $message->to($to);
                        $message->priority(1);
                    });

                    $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                    $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                    $actualizar_fecha->update();
                }
                elseif($dias_restantes >= 5 && $dias_restantes < 10 && Carbon::now()->format('Y-m-d') != $act_msg[$i]->ACM_Fecha_Fin->format('Y-m-d')) {
                    if(!$act_msg[$i]->ACM_Notificacion) {
                        $dias_restantes_alert = "<span class='label warning'>Tener en cuenta, días restantes: $dias_restantes</span>";
                        $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                        $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                        $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                        $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                        $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                        $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                        $to = $act_msg[$i]->correo_responsable;
                        $subject = "Acitividad de Mejoramiento [Notificación]";
                        $colletion = Collection::make($act_msg[$i]);
                        $info_mensaje = $colletion->toArray();

                        Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                            $message->from($to, $for);
                            $message->subject($subject);
                            $message->to($to);
                            $message->priority(2);
                        });

                        $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                        $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                        $actualizar_fecha->update();
                    }
                    else{
                        $fecha_notificacion = Carbon::parse($act_msg[$i]->ACM_Notificacion);
                        $dif_dias_notificacion = $fecha_notificacion->diffInDays(Carbon::now()->format('Y-m-d'));
                        if($dif_dias_notificacion > 2) {
                            $dias_restantes_alert = "<span class='label warning'>Tener en cuenta, días restantes: $dias_restantes</span>";
                            $act_msg[$i] = array_add($act_msg[$i], 'dias_restantes', $dias_restantes_alert);
                            $datos_responsable = ActividadesMejoramiento::findOrFail($act_msg[$i]->PK_ACM_Id);
                            $act_msg[$i] = array_add($act_msg[$i], 'nombre_responsable', $datos_responsable->responsable->usuarios->name);
                            $act_msg[$i] = array_add($act_msg[$i], 'apellido_responsable', $datos_responsable->responsable->usuarios->lastname);
                            $for = $act_msg[$i]->nombre_responsable . " " . $act_msg[$i]->apellido_responsable;
                            $act_msg[$i] = array_add($act_msg[$i], 'correo_responsable', $datos_responsable->responsable->usuarios->email);
                            $to = $act_msg[$i]->correo_responsable;
                            $subject = "Acitividad de Mejoramiento [Notificación]";
                            $colletion = Collection::make($act_msg[$i]);
                            $info_mensaje = $colletion->toArray();

                            Mail::send('email_actividades', $info_mensaje, function ($message) use ($for, $to, $subject){
                                $message->from($to, $for);
                                $message->subject($subject);
                                $message->to($to);
                                $message->priority(2);
                            });

                            $actualizar_fecha = ActividadesMejoramiento::find($act_msg[$i]->PK_ACM_Id);
                            $actualizar_fecha->ACM_Notificacion = Carbon::now()->format('Y-m-d');
                            $actualizar_fecha->update();
                        }
                    }
                }
            }
        }
        /**
         * Esta es la logica empleada para el envio de notificaciones por correos
         */
    }
}
