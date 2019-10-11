<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Evidencia extends Model
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
    protected $table = 'TBL_Evidencias';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_EVD_Id';
    
    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_EVD_Id', 'created_at', 'updated_at'];
    
    /**
     * Relación de uno a muchos de la tabla actvidades de mejoramiento
     * Un actvidad de mejoramiento tiene muchas evidencias
     * y una evidencia tiene un actvidad de mejoramiento
     */
    public function actividad_mejoramiento()
    {
        return $this->belongsTo(ActividadesMejoramiento::class, 'FK_EVD_Actividad_Mejoramiento', 'PK_ACM_Id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            if ($model->archivo) {
                $ruta = str_replace('storage', 'public', $model->archivo->ruta);
                Storage::delete($ruta);
            }
        });
    }

    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'FK_EVD_Archivo', 'PK_ACV_Id');
    }
}
