<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class RespuestaPregunta extends Model
{
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'historial';

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
     * Relacion muchos a muchos con la tabla solucion_encuesta, una respuesta puede pertecer a muchas
     * soluciones de la encuesta y una solucion de la encuesta puede tener muchas respuestas
     *
     */
    public function solucion()
    {
        return $this->hasMany(SolucionEncuesta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }
}
