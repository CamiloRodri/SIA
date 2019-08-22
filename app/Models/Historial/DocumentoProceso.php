<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class DocumentoProceso extends Model
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
    protected $table = 'TBL_Documentos_Proceso';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DPC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DPC_Id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos con la tabla indicadores documentales
     * un documento solo puede tener un indicador, pero un indicador puede tener muchos documentos
     *
     */
    public function indicadorDocumental()
    {
        return $this->belongsTo(IndicadorDocumental::class, 'FK_DPC_Indicador', 'PK_IDO_Id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_DPC_Proceso', 'PK_PCS_Id');
    }

}
