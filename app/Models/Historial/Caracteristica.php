<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
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
    protected $table = 'TBL_Caracteristicas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CRT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_CRT_Id', 'created_at', 'updated_at'];

    public function factor()
    {
        return $this->belongsTo(Factor::class, 'FK_CRT_Factor', 'PK_FCT_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla indicadores
     * Un indicador puede tener muchas caracteristicas
     * y un caracterista un solo indicador
     */
    public function indicadores_documentales()
    {
        return $this->hasMany(IndicadorDocumental::class, 'FK_IDO_Caracteristica', 'PK_CRT_Id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }


}
