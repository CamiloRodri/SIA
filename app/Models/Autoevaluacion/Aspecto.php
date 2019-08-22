<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Aspecto extends Model
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
    protected $table = 'TBL_Aspectos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ASP_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ASP_Id', 'created_at', 'updated_at'];

    /**
     * Obtener nombre de la caracteristica con su respectivo identificador.
     *
     * @return string
     */
    /**
     * Funcion que uno los dos campos de identificacion
     * y nombre del aspecto en una cadena
     */
    public function getNombreAspectoAttribute()
    {
        return "{$this->ASP_Identificador}. {$this->ASP_Nombre}";
    }

    /**
     * Relacion de uno a muchos de la tabla caracteristicas
     * Una caracteristia tiene muchos ambitos
     * y un ambito una sola caracteristica
     */
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_ASP_Caracteristica', 'PK_CRT_Id');
    }
}
