<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DocumentoInstitucional extends Model
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
    protected $table = 'TBL_Documentos_Institucionales';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DOI_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */

    protected $guarded = ['PK_DOI_Id', 'created_at', 'updated_at'];

    /**
     * The "booting" method of the model.
     * Se utiliza cada vez que se elimina un documento institucional
     * para eliminar el archivo del servidor
     *
     * @return void
     */

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

    /**
     * Relación uno a muchos con la tabla grupo documentos, un documento
     * institucional solo puede tener un grupo pero un grupo puede tener
     * muchos documentos
     *
     * @return void
     */
    public function grupodocumento()
    {
        return $this->hasOne(GrupoDocumento::class, 'PK_GRD_Id', 'FK_DOI_GrupoDocumento');
    }

    /**
     * Relación uno a uno con tabla archivo
     * un documento de autoevaluación solo puede tener un archivo relacionado
     *
     */
    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'FK_DOI_Archivo', 'PK_ACV_Id');
    }
}
