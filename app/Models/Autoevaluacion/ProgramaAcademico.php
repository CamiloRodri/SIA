<?php

namespace App\Models\Autoevaluacion;

use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class ProgramaAcademico extends Model
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
    protected $table = 'TBL_Programas_Academicos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PAC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PAC_Id', 'created_at', 'updated_at'];

    /**
     * Relacion de muchos a uno de la tabla proceso
     * un programa tiene un proceso
     * y un proceso muchos programas
     */
    public function proceso()
    {
        return $this->hasMany(Proceso::class, 'FK_PCS_Programa', 'PK_PAC_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla facultad
     * un programa tiene una facultad
     * y una facultad muchos programas
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'FK_PAC_Facultad', 'PK_FCD_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla sedde
     * un programa tiene una sede
     * y una sede muchos programas
     */
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'FK_PAC_Sede', 'PK_SDS_Id');
    }

    /**
     * Relacion de uno a muchos de la tabla estados
     * un programa tiene un estado
     * y un estado muchos programas
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_PAC_Estado', 'PK_ESD_Id');
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
