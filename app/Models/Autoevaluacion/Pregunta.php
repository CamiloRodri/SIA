<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Pregunta extends Model
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
    protected $table = 'TBL_Preguntas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PGT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PGT_Id', 'created_at', 'updated_at'];

    /**
     * Relacion uno a muchos con la tabla estado, una pregunta solo puede tener
     * un estado (habilitada o deshabilitada), pero un estado puede determinar a muchas preguntas
     *
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_PGT_Estado', 'PK_ESD_Id');
    }

    /**
     * Relacion uno a muchos con la tabla tipo respuesta, una pregunta solo puede tener
     * un tipo de respuesta, pero un tipo de respuesta puede pertenecer a muchas preguntas
     *
     */
    public function tipo()
    {
        return $this->belongsTo(TipoRespuesta::class, 'FK_PGT_TipoRespuesta', 'PK_TRP_Id');
    }

    /**
     * Relacion uno a muchos con la tabla caracteristicas, una pregunta solo puede apuntar
     * a una caracteristica, pero una caracteristica puede ser apuntada por muchas preguntas.
     *
     */
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }

    /**
     * Relacion muchos a uno con la tabla respuestas, una pregunta puede tener muchas
     * opciones de respuesta, pero una respuesta solo puede pertenecer a una pregunta
     *
     */
    public function respuestas()
    {
        return $this->hasMany(RespuestaPregunta::class, 'FK_RPG_Pregunta', 'PK_PGT_Id');
    }

    /**
     * Relacion muchos a uno con la tabla preguntas_encuesta, una pregunta pueden pertenecer
     * a muchas encuestas.
     *
     */
    public function preguntas_encuesta()
    {
        return $this->hasMany(PreguntaEncuesta::class, 'FK_PEN_Pregunta', 'PK_PGT_Id');
    }

}
