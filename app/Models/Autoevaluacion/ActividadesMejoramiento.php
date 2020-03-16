<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ActividadesMejoramiento extends Model
{
    use LogsActivity;
    protected static $logUnguarded = true;
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'autoevaluacion';

    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Actividades_Mejoramiento';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ACM_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ACM_Id', 'created_at', 'updated_at'];
    //
    protected $dates = ['ACM_Fecha_Inicio', 'ACM_Fecha_Fin'];

    public function Caracteristicas()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_ACM_Caracteristica', 'PK_CRT_Id');
    }

    public function PlanMejoramiento()
    {
        return $this->belongsTo(PlanMejoramiento::class, 'FK_ACM_Plan_Mejoramiento', 'PK_PDM_Id');
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'FK_ACM_Responsable', 'PK_RPS_Id');
    }

    public function califica()
    {
        return $this->hasOne(CalificaActividad::class, 'FK_CLA_Actividad_Mejoramiento', 'PK_ACM_Id');
    }

}
