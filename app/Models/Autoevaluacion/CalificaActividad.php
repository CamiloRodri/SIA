<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CalificaActividad extends Model
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
    protected $table = 'TBL_Califica_Actividades';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CLA_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_CLA_Id', 'created_at', 'updated_at'];

    public function actividadesMejoramiento()
    {
        return $this->hasOne(ActividadesMejoramiento::class, 'FK_CLA_Actividad_Mejoramiento', 'PK_ACM_Id');
    }

    public function fechasCorte()
    {
        return $this->belongsTo(FechaCorte::class, 'FK_CLA_Fecha_Corte', 'PK_FCO_Id');
    }

}
