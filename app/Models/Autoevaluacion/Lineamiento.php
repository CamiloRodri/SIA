<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Lineamiento extends Model
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
    protected $table = 'TBL_Lineamientos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_LNM_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_LNM_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla factor
     * Un factor tiene un lineamiento
     * y un lineamiento muchos factores
     */
    public function factor_()
    {
        return $this->hasMany(Factor::class, 'FK_FCT_Lineamiento', 'PK_LNM_Id');
    }
}
