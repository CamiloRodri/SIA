<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BancoEncuestas extends Model
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
    protected $table = 'TBL_Banco_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_BEC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_BEC_Id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a uno con la tabla encuestas.
     * El banco de encuestas puede tener muchas encuestas,
     * la encuesta pertecene a un solo banco de encuesta.
     */
    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'FK_ECT_Banco_Encuestas', 'PK_BEC_Id');
    }

}
