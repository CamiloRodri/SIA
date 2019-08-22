<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PreguntaEncuesta extends Model
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
    protected $table = 'TBL_Preguntas_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PEN_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PEN_Id', 'created_at', 'updated_at'];

    /**
     * Relacion muchos a uno con la tabla preguntas, una encuesta puede tener
     * muchas preguntas, pero la pregunta solo puede pertenecer a una encuesta
     *
     */
    public function preguntas()
    {
        return $this->belongsTo(Pregunta::class, 'FK_PEN_Pregunta', 'PK_PGT_Id');
    }

    /**
     * Relacion uno a muchos con la tabla grupos de interes, una pregunta solo puede ir
     * dirigida a un grupo de interes, pero un grupo de interes puede tener muchas preguntas.
     *
     */
    public function grupos()
    {
        return $this->belongsto(GrupoInteres::class, 'FK_PEN_GrupoInteres', 'PK_GIT_Id');
    }

    /**
     * Relacion muchos a uno con la tabla dependecia, una encuesta puede tener
     * muchas preguntas, pero una pregunta solo pertenece a un banco de encuesta
     *
     * @return void
     */
    public function banco()
    {
        return $this->belongsTo(BancoEncuestas::class, 'FK_PEN_Banco_Encuestas', 'PK_BEC_Id');
    }
}
