<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class TipoDocumento extends Model
{
    use LogsActivity;
    protected static $logFillable = true;
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
    protected $table = 'TBL_Tipo_Documentos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_TDO_Id';

    /**
     * Atributos del modelo que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = ['TDO_Nombre'];
}
