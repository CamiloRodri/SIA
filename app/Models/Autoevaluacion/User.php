<?php

namespace App\Models\Autoevaluacion;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use LogsActivity;
    protected static $logFillable = true;
    use Notifiable;
    use HasRoles;

    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'autoevaluacion';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lastname', 'id_estado', 'cedula','estado_pass'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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

    /**
     * Relacion de uno a muchos de la tabla estado
     * un estado tiene muchos usuarios
     * y un usuario tiene un estado
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'PK_ESD_Id');
    }

    /**
     * Relacion de mcuhos a muchos de la tabla procesos
     * un proceso tiene muchos usuarios
     * y un usuario tiene un proceso
     */
    public function procesos()
    {
        return $this->belongsToMany(Proceso::class, 'TBL_Procesos_Usuarios', 'FK_PCU_Usuario', 'FK_PCU_Proceso');
    }

    /**
     * Relacion de uno a muchos de la tabla programa
     * un programa tiene muchos usuarios
     * y un usuario tiene un programa
     */
    public function programa()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'id_programa', 'PK_PAC_Id');
    }

}
