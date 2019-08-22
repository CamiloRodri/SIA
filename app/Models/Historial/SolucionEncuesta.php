<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class SolucionEncuesta extends Model
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
    protected $table = 'TBL_Solucion_Encuesta';

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
     * Relacion muchos a muchos con la tabla respuestas_pregunta, una solucion de una encuesta puede tener
     * muchas respuestas y una respuesta puede estar en muchas soluciones de la encuesta.
     *
     */
    public function respuestas()
    {
        return $this->belongsTo(RespuestaPregunta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }

}
