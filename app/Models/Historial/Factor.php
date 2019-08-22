<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'historial';

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
        return "{$this->FCT_Nombre}";
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

    public function lineamiento()
    {
        return $this->belongsTo(Lineamiento::class, 'FK_FCT_Lineamiento', 'PK_LNM_Id');
    }

}
