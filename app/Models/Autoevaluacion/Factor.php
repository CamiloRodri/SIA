<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Factor extends Model
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
    protected $table = 'TBL_Factores';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCT_Id', 'created_at', 'updated_at'];

    /**
     * Obtener nombre del factor con su respectivo identificador.
     * Funcion que uno los dos campos de identificacion
     * y nombre del factor en una cadena
     *
     * @return string
     */
    public function getNombreFactorAttribute()
    {
        return "{$this->FCT_Identificador}. {$this->FCT_Nombre}";
    }

    /**
     * Relacion de uno a muchos de la tabla estado
     * Un estado tiene muchos factores
     * y un factor tiene un estado
     */
    public function estado()
    {
        return $this->hasOne(Estado::class, 'PK_ESD_Id', 'FK_FCT_Estado');
    }

    /**
     * Relacion de uno a muchos de la tabla lineamiento
     * Un lineamiento tiene muchos factores
     * y un factor tiene un lineamiento
     */
    public function lineamiento()
    {
        return $this->hasOne(Lineamiento::class, 'PK_LNM_Id', 'FK_FCT_Lineamiento');
    }

    /**
     * Relacion de muchos a uno de la tabla caracteristicas
     * Un factor tiene muchas caracteristicas
     * y un caracteristicas tiene un factro
     */
    public function caracteristica()
    {
        return $this->hasMany(Caracteristica::class, 'FK_CRT_Factor', 'PK_FCT_Id');
    }
}
