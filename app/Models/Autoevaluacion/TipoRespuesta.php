<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TipoRespuesta extends Model
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
    protected $table = 'TBL_Tipo_Respuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_TRP_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_TRP_Id', 'created_at', 'updated_at'];

    /**
     * Relacion uno a muchos con la tabla estado, un tipo de respuesta solo puede tener
     * un estado (habilitado o deshabilitado), pero un estado puede determinar muchos tipos de respuestas.
     *
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_TRP_Estado', 'PK_ESD_Id');
    }
}
