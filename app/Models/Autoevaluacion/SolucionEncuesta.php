<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SolucionEncuesta extends Model
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
    protected $table = 'TBL_Solucion_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_SEC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_SEC_Id', 'created_at', 'updated_at'];

    /**
     * Relacion uno a muchos con la tabla encuestado, una solucion de una encuesta solo puede ser realizada
     * por un encuestado, pero una encuestado puede solucionar muchas veces la encuesta.
     *
     */
    public function encuestados()
    {
        return $this->belongsTo(Encuestado::class, 'FK_SEC_Encuestado', 'PK_ECD_Id');
    }

    /**
     * Relacion muchos a muchos con la tabla respuestas_pregunta, una solucion de una encuesta puede tener
     * muchas respuestas y una respuesta puede estar en muchas soluciones de la encuesta.
     *
     */
    public function respuestas()
    {
        return $this->belongsTo(RespuestaPregunta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }
}
