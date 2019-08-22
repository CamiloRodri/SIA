<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GrupoInteres extends Model
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
    protected $table = 'TBL_Grupos_Interes';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_GIT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_GIT_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de uno a muchos de la tabla estado
     * Un estado tiene muchos grupos
     * y un grupo tiene un estado
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_GIT_Estado', 'PK_ESD_Id');
    }

    /**
     * Relacion muchos a uno con la tabla preguntas_encuestas, un grupo de interes puede tener
     * muchas preguntas, pero una pregunta solo va destinada a un grupo de interes en especifico.
     *
     */
    public function preguntas_encuesta()
    {
        return $this->hasMany(PreguntaEncuesta::class, 'FK_PEN_GrupoInteres', 'PK_GIT_Id');
    }
}
