<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sede extends Model
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
    protected $table = 'TBL_Sedes';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_SDS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_SDS_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla proceso
     * una sede tiene un proceso
     * y un proceso muchas sedes
     */
    public function proceso()
    {
        return $this->hasMany(Proceso::class, 'FK_PCS_Sede', 'PK_SDS_Id');
    }

    /**
     * Relacion de uno a muchos de la tabla estado
     * una sede tiene un estado
     * y un estado muchas sedes
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_SDS_Estado', 'PK_ESD_Id');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'FK_SDS_Institucion', 'PK_ITN_Id');
    }
}
