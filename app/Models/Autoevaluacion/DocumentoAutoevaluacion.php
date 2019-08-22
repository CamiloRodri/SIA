<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;


class DocumentoAutoevaluacion extends Model
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
    protected $table = 'TBL_Documentos_Autoevaluacion';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DOA_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DOA_Id', 'created_at', 'updated_at'];


    /**
     * The "booting" method of the model.
     * Se utiliza cada vez que se elimina un documento de autoevaluacion
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
     * Relación uno a uno con tabla archivo
     * un documento de autoevaluación solo puede tener un archivo relacionado
     *
     */
    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'FK_DOA_Archivo', 'PK_ACV_Id');
    }

    /**
     * Relación uno a muchos con la tabla procesos
     * para identificar a que proceso de autoevaluacion pertenece cada
     * documento, un proceso puede tener muchos documentos, pero un
     * documento solo puede tener un proceso
     *
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_DOA_Proceso', 'PK_PCS_Id');
    }

    /**
     * Relación uno a muchos con la tabla indicadores documentales
     * un documento solo puede tener un indicador, pero un indicador puede tener muchos documentos
     *
     */
    public function indicadorDocumental()
    {
        return $this->belongsTo(IndicadorDocumental::class, 'FK_DOA_IndicadorDocumental', 'PK_IDO_Id');
    }

    /**
     * Relación uno a uno con la tabla tipo documento
     * esta especifica que tipo de documento es el documento de autoevaluacion
     *
     * @return void
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'FK_DOA_TipoDocumento', 'PK_TDO_Id');
    }

    /**
     * Relacion uno a muchos con la tabla dependecia, un documento solo puede tener
     * una dependencia de expedicion, pero una dependencia puede tener muchos documentos
     *
     * @return void
     */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'FK_DOA_Dependencia', 'PK_DPC_Id');
    }
}
