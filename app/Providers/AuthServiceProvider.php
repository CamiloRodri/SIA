<?php

namespace App\Providers;

use App\Models\Autoevaluacion\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**
         * Gate la cual brinda la seguridad necesaria para que un usuarios solo
         * puedan ver los datos de los procesos a los cuales pertenece.
         */
        Gate::define('autorizar', function (User $user, $id_proceso) {
            return $user->procesos()->get()->contains($id_proceso);
        });
    }
}
