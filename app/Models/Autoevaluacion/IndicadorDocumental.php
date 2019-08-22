<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class IndicadorDocumental extends Model
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
     * Obtener nombre de la característica con su respectivo identificador.
     *
     * @return string
     */
    public function getNombreIndicadorAttribute()
    {
        return "{$this->IDO_Identificador}. {$this->IDO_Nombre}";
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

    /**
     * Relación uno a muchos con la tabla estados
     * un indicador puede tener un solo estado, un estado puede tener muchos indicadores
     *
     * @return void
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_IDO_Estado', 'PK_ESD_Id');
    }

    /**
     * Relación muchos a uno con la tabla documentos autoevaluación
     * Un indicador puede tener muchos documentos de autoevaluación,
     * un documento de autoevaluación solo puede tener un indicador
     *
     * @return void
     */
    public function documentosAutoevaluacion()
    {
        return $this->hasMany(DocumentoAutoevaluacion::class, 'FK_DOA_IndicadorDocumental', 'PK_IDO_Id');
    }
}
