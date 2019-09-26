<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Consolidacion extends Model
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
    protected $table = 'TBL_Consolidaciones';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CNS_Id';

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
    protected $guarded = ['PK_CNS_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla procesos
     * Muchas fechas de Corte tiene un Proceso
     * y un proceso, muchas fechas de corte
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_CNS_Proceso', 'PK_PCS_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla procesos
     * Muchas fechas de Corte tiene un Proceso
     * y un proceso, muchas fechas de corte
     */
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_CNS_Caracteristica', 'PK_CRT_Id');
    }
}
