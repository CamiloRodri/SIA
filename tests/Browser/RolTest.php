<?php

namespace Tests\Browser;

use App\Models\Autoevaluacion\User;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;


class RolTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testVerRoles()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin')
                ->clickLink('Usuarios')
                ->clickLink('Roles')
                ->assertPathIs('/admin/roles')
                ->assertSee('Roles')
                ->pause(1000)//peticiones ajax
                ->waitForText('Siguiente')
                ->with('.table', function ($table) {
                    $table->assertSee('SUPERADMIN');
                });
        });
    }

    public function testCrearRol()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/roles')
                ->assertSee('Agregar Rol')
                ->clickLink('Agregar Rol')
                ->assertPathIs('/admin/roles/create')
                ->assertSee('Crear Rol')
                ->type('name', 'El rol')
                ->select('permission[]')
                ->select('permission[]')
                ->press('Crear Rol')
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Registro exitoso!');
        });
    }

    public function testModificarRol()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $rol_a_modificar = Role::where('name', 'El rol')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/roles')
                ->assertSee('Roles')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $rol_a_modificar->name)
                ->pause(500)
                ->with('.table', function ($table) use ($rol_a_modificar) {
                    $table
                        ->assertSee($rol_a_modificar->name)
                        ->click('.edit');
                })
                ->assertPathIs('/admin/roles/' . $rol_a_modificar->id . '/edit')
                ->assertSee('Modificar Rol')
                ->type('name', 'Super rol')
                ->press('Modificar Rol')
                ->pause(2000)
                ->waitFor('.ui-pnotify-title')
                ->assertSee('Rol Modificado!');
        });
    }

    public function testEliminarUsuario()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $rol_a_eliminar = Role::where('name', 'Super rol')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/roles')
                ->assertSee('Roles')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $rol_a_eliminar->name)
                ->pause(500)
                ->with('.table', function ($table) use ($rol_a_eliminar) {
                    $table
                        ->click('.remove');
                })
                ->whenAvailable('.swal2-container', function ($modal) {
                    $modal->assertSee('Esta seguro?')
                        ->press('Si, eliminar!');
                })
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Rol Eliminado!');
        });

    }
}
