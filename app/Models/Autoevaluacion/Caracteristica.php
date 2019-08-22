<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Caracteristica extends Model
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
    protected $table = 'TBL_Caracteristicas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CRT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_CRT_Id', 'created_at', 'updated_at'];

    /**
     * Obtener nombre de la caracteristica con su respectivo identificador.
     *
     * @return string
     */
    /**
     * Funcion que uno los dos campos de identificacion
     * y nombre de la caracteristica en una cadena
     */
    public function getNombreCaracteristicaAttribute()
    {
        return "{$this->CRT_Identificador}. {$this->CRT_Nombre}";
    }

    /**
     * Relacion de muchos a uno de la tabla aspecto
     * Una caracteristia tiene muchos aspectos
     * y un aspecto una sola caracteristica
     */
    public function aspecto()
    {
        return $this->hasMany(Aspecto::class, 'FK_ASP_Caracteristica', 'PK_CRT_Id');
    }

    /**
     * Relacion de uno a muchos de la tabla factor
     * Un factor tiene muchas caracteristicas
     * y una caracteristica un solo factro
     */
    public function factor()
    {
        return $this->hasOne(Factor::class, 'PK_FCT_Id', 'FK_CRT_Factor');
    }

    /**
     * Relacion uno a muchos de la tabla estado
     * Una caracteristia tiene un estado
     * y un estado muchas caracteristicas
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_CRT_Estado', 'PK_ESD_Id');
    }

    /**
     * Relacion de uno a muchos de la tabla ambito
     * Un ambito muchas caracteristicas
     * y un caracterista un solo ambito
     */
    public function ambitoResponsabilidad()
    {
        return $this->belongsTo(AmbitoResponsabilidad::class, 'FK_CRT_Ambito', 'PK_AMB_Id');
    }

    /**
     * Relacion de muchos a uno de la tabla indicadores
     * Un indicador puede tener muchas caracteristicas
     * y un caracterista un solo indicador
     */
    public function indicadores_documentales()
    {
        return $this->hasMany(IndicadorDocumental::class, 'FK_IDO_Caracteristica', 'PK_CRT_Id');
    }

    /**
     * Relacion muchos a uno con la tabla preguntas, una caracteristicas puede ser apuntada por
     * muchas preguntas, pero una pregunta solo puede apuntar a una caracteristica
     *
     */
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }


}
