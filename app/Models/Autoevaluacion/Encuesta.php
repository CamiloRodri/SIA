<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Encuesta extends Model
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
    protected $table = 'TBL_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ECT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ECT_Id', 'created_at', 'updated_at'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ECT_FechaPublicacion', 'ECT_FechaFinalizacion'];

    /**
     * Relacion uno a muchos con la tabla estado, una encuesta solo puede tener
     * un estado (habilitado o deshabilitado), pero un estado puede determinar a cualquier encuesta.
     *
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_ECT_Estado', 'PK_ESD_Id');
    }

    /**
     * Relacion uno a muchos con la tabla banco de encuestas, un encuesta solo puede pertencer
     * a un banco de encuestas, pero una banco de encuestas puede tener muchas encuestas
     *
     */
    public function banco()
    {
        return $this->belongsTo(BancoEncuestas::class, 'FK_ECT_Banco_Encuestas', 'PK_BEC_Id');
    }

    /**
     * Relacion muchos a uno con la tabla proceso, una encuesta puede pertenecer a muchos procesos,
     * pero un proceso solo tiene una encuesta vinculada.
     *
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_ECT_Proceso', 'PK_PCS_Id');
    }


}
