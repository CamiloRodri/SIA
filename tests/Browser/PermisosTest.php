<?php

namespace Tests\Browser;

use App\Models\Autoevaluacion\User;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Permission;
use Tests\DuskTestCase;

class PermisosTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testVerPermisos()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin')
                ->clickLink('Usuarios')
                ->clickLink('Permisos')
                ->assertPathIs('/admin/permisos')
                ->assertSee('Permisos')
                ->pause(1000)//peticiones ajax
                ->waitForText('Siguiente')
                ->with('.table', function ($table) {
                    $table->assertSee('ACCESO_MODULO_SUPERADMINISTRADOR');
                });
        });
    }

    public function testCrearPermiso()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/permisos')
                ->assertSee('Agregar Permiso')
                ->clickLink('Agregar Permiso')
                ->assertSee('Crear Permiso')
                ->type('name', 'Prueba permiso')
                ->press('Crear')
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Registro exitoso!');
        });
    }

    public function testModificarPermiso()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $permiso_a_modificar = Permission::where('name', 'Prueba permiso')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/permisos')
                ->assertSee('Permisos')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $permiso_a_modificar->name)
                ->pause(500)
                ->with('.table', function ($table) use ($permiso_a_modificar) {
                    $table
                        ->assertSee($permiso_a_modificar->name)
                        ->click('.edit');
                })
                ->assertSee('Modificar Permisos')
                ->type('name', 'Super permiso')
                ->press('Modificar')
                ->waitFor('.ui-pnotify-title')
                ->assertSee('Permiso Modificado!');
        });
    }

    public function testEliminarUsuario()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $permiso_a_eliminar = Permission::where('name', 'Super permiso')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/permisos')
                ->assertSee('Permisos')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $permiso_a_eliminar->name)
                ->pause(500)
                ->with('.table', function ($table) use ($permiso_a_eliminar) {
                    $table
                        ->click('.remove');
                })
                ->whenAvailable('.swal2-container', function ($modal) {
                    $modal->assertSee('Esta seguro?')
                        ->press('Si, eliminar!');
                })
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Permiso Eliminado!');
        });

    }
}
