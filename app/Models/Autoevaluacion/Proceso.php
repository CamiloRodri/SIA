<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;

class Proceso extends Model
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
    protected $table = 'TBL_Procesos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PCS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PCS_Id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['PCS_FechaInicio', 'PCS_FechaFin'];

    /**
     * Get the user's full name.
     *
     * @return string
     */

    /**
     *es un mutador que muestra el nombre completo del proceso
     *si es institucional coloca institucional y el nombre del proceso
     *Si es un proceso para un programa se colcoa el nombre del programa y
     *el nombre del proceso
     */
    public function getNombreProcesoAttribute()
    {
        $sede = 'Institucional';
        if ($this->programa) {
            $sede = $this->programa->sede->SDS_Nombre;
        }
        return "{$sede} {$this->PCS_Nombre}";
    }

    /**
     * se ejecuta cada vez que se elimina un proceso verifica si existe
     * un archivo de autoevaluacion y lo elimina en
     * caso de existir del servidor
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $procesos = $model::has('documentosAutoevaluacion.archivo')->with('documentosAutoevaluacion.archivo')->get();
            foreach ($procesos as $proceso) {
                foreach ($proceso->documentosAutoevaluacion as $documento) {
                    if ($documento->archivo) {
                        $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                        Storage::delete($ruta);
                    }
                }
            }
        });

    }


    public function programa()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'FK_PCS_Programa', 'PK_PAC_Id');
    }

    public function fase()
    {
        return $this->hasOne(Fase::class, 'PK_FSS_Id', 'FK_PCS_Fase');
    }

    public function lineamiento()
    {
        return $this->belongsTo(Lineamiento::class, 'FK_PCS_Lineamiento', 'PK_LNM_Id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'TBL_Procesos_Usuarios', 'FK_PCU_Proceso', 'FK_PCU_Usuario');
    }

    /**
     * Relacion uno a muchos con la tabla encuestas, un proceso solo puede tener
     * vinculada una encuesta, pero una encuesta puede pertenecer a muchos proceso.
     *
     */
    public function encuestas()
    {
        return $this->hasOne(Encuesta::class, 'FK_ECT_Proceso', 'PK_PCS_Id');
    }

    public function documentosAutoevaluacion()
    {
        return $this->hasMany(DocumentoAutoevaluacion::class, 'FK_DOA_Proceso', 'PK_PCS_Id');
    }

}
