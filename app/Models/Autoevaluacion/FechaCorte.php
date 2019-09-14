<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FechaCorte extends Model
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
    protected $table = 'TBL_Fechas_corte';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCO_Id';

    /**
     * Indica si el modelo tiene timestamps(update_at, created_at)
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCO_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla procesos
     * Muchas fechas de Corte tiene un Proceso
     * y un proceso, muchas fechas de corte
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_FCO_Proceso', 'PK_PCS_Id');
    }
}
