<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Archivo extends Model
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
    protected $table = 'TBL_Archivos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ACV_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ACV_Id', 'created_at', 'updated_at'];

    /**
     * Función que se ejecuta cada vez que se borra
     * Elimina los archivos del servidor automáticamente
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $ruta = str_replace('storage', 'public', $model->ruta);
            Storage::delete($ruta);
        });
    }

    /**
     * Relación de la tabla archivos con los documentos institucionales
     *
     */
    public function documentoinstitucional()
    {
        return $this->hasMany(DocumentoInstitucional::class, 'FK_DOI_Archivo', 'PK_ACV_Id');
    }
}
