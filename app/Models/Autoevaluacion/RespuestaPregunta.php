<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RespuestaPregunta extends Model
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
    protected $table = 'TBL_Respuestas_Preguntas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_RPG_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_RPG_Id', 'created_at', 'updated_at'];

    /**
     * Relacion uno a muchos con la tabla pregunta, una respuesta solo puede pertenecer
     * a una pregunta, pero una pregunta puede tener muchas respuestas
     *
     */
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'FK_RPG_Pregunta', 'PK_PGT_Id');
    }

    /**
     * Relacion uno a muchos con la tabla ponderaciones, una respuesta solo puede tener
     * una ponderacion, pero una ponderacion puede pertenecer a muchas respuestas.
     *
     * @return void
     */
    public function ponderacion()
    {
        return $this->belongsTo(PonderacionRespuesta::class, 'FK_RPG_PonderacionRespuesta', 'PK_PRT_Id');
    }

    /**
     * Relacion muchos a muchos con la tabla solucion_encuesta, una respuesta puede pertecer a muchas
     * soluciones de la encuesta y una solucion de la encuesta puede tener muchas respuestas
     *
     */
    public function solucion()
    {
        return $this->hasMany(SolucionEncuesta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }
}
