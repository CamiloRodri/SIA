<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Indicador extends Model
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
    protected $table = 'TBL_Indicadores';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_EDC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_EDC_Id', 'created_at', 'updated_at'];
}
