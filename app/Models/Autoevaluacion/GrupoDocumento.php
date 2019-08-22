<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GrupoDocumento extends Model
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
    protected $table = 'TBL_Grupos_Documentos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_GRD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_GRD_Id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a uno con la tabla documento institucional
     * un grupo puede tener muchos documentos institucionales
     *
     * @return void
     */
    public function documentoinstitucional()
    {
        return $this->hasMany(DocumentoInstitucional::class, 'FK_DOI_GrupoDocumento', 'PK_GRD_Id');
    }
}
