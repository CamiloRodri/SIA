<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Institucion extends Model
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
    protected $table = 'TBL_Instituciones';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ITN_Id';
    
    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ITN_Id', 'created_at', 'updated_at'];
    
    /**
     * Relación de uno a muchos de la tabla estado
     * Un estado tiene muchas instituciones
     * y una intitución tiene un estados
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_ITN_Estado', 'PK_ESD_Id');
    }

    /**
     * Relación de uno a muchos de la tabla estado
     * Una metodología tiene muchas instituciones
     * y una intitución tiene una metodología
     */
    public function metodologia()
    {
        return $this->belongsTo(Metodologia::class, 'FK_ITN_Metodologia', 'PK_MTD_Id');
    }

}
