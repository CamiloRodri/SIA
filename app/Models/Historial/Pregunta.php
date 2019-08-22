<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
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

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaPregunta::class, 'FK_RPG_Pregunta', 'PK_PGT_Id');
    }


}
