<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class IndicadorDocumental extends Model
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
    protected $table = 'TBL_Indicadores_Documentales';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_IDO_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_IDO_Id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a uno con la tabla documentos autoevaluación
     * Un indicador puede tener muchos documentos de autoevaluación,
     * un documento de autoevaluación solo puede tener un indicador
     *
     * @return void
     */
    public function documentosAutoevaluacion()
    {
        return $this->hasMany(DocumentoProceso::class, 'FK_DPC_Indicador', 'PK_IDO_Id');
    }

    /**
     * Relación uno a muchos con la tabla características
     * un indicador pertenece a una característica y una característica
     * puede tener muchos indicadores
     *
     * @return void
     */
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_IDO_Caracteristica', 'PK_CRT_Id');
    }

}
