<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Encuestado extends Model
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
    protected $table = 'TBL_Encuestados';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ECD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ECD_Id', 'created_at', 'updated_at'];

    /**
     * Relacion uno a muchos con la tabla grupos de interes, un encuesta solo puede pertenecer
     * a un grupo de interes, pero un grupo de interes puede tener muchos encuestados.
     *
     */
    public function grupos()
    {
        return $this->belongsTo(GrupoInteres::class, 'FK_ECD_GrupoInteres', 'PK_GIT_Id');
    }

    public function solucion()
    {
        return $this->hasMany(SolucionEncuesta::class, 'FK_SEC_Encuestado', 'PK_ECD_Id');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'FK_ECD_Encuesta', 'PK_ECT_Id');
    }
}
