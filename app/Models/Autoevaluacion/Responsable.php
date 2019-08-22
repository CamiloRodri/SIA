<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Responsable extends Model
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
    protected $table = 'TBL_Responsables';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_RPS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_RPS_Id', 'created_at', 'updated_at'];
   
    public function usuarios()
    {
        return $this->belongsTo(User::class, 'FK_RPS_Responsable', 'id');
    }
    public function cargo()
    {
        return $this->belongsTo(CargoAdministrativo::class, 'FK_RPS_Cargo', 'PK_CAA_Id');
    }
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_RPS_Proceso', 'PK_PCS_Id');
    }

    
}
