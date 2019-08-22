<?php

namespace App\Models\Autoevaluacion;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class Usuario extends Authenticatable
{
    use Notifiable;
    use HasRoles;

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
    protected $table = 'TBL_Usuarios';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_USU_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ACT_Id', 'created_at', 'updated_at', 'remember_token'];

    /**
     * Atributos que no deben ser mostrados.
     *
     * @var array
     */
    protected $hidden = ['USU_Clave', 'remember_token'];

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }

    /**
     * Relacion de muchos a muchos de la tabla rol
     * un usuario tiene muchos roles
     * y un rol tiene muchos usuarios
     */
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
