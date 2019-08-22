<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Estado extends Model
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
    protected $table = 'TBL_Estados';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ESD_Id';

    /**
     * Indica si el modelo tiene timestamps(update_at, created_at)
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ESD_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla factor
     * Un estado tiene muchos factores
     * y un factor un estados
     */
    public function factor()
    {
        return $this->hasMany(Factor::class, 'FK_FCT_Estado', 'PK_ESD_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla factor
     * Un estado tiene muchas caracteristicas
     * y un caracteristica un estado
     */
    public function caracteristica()
    {
        return $this->hasMany(Caracteristica::class, 'FK_CRT_Estado', 'PK_ESD_Id');
    }

}
