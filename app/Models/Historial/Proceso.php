<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
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
    protected $table = 'TBL_Procesos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PCS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PCS_Id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['PCS_Fecha_Proceso'];

    public function lineamiento()
    {
        return $this->belongsTo(Lineamiento::class, 'FK_PCS_Lineamiento', 'PK_LNM_Id');
    }

}
