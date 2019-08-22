<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Facultad extends Model
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
    protected $table = 'TBL_Facultades';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCD_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de uno a muchos de la tabla estado
     * Un estado tiene muchas facultades
     * y una facultad tiene un estados
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_FCD_Estado', 'PK_ESD_Id');
    }
}
