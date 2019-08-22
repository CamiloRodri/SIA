<?php

namespace Tests\Browser;

use App\Models\Autoevaluacion\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testVerUsuarios()
    {
        $user = User::all();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user[0])
                ->resize(1300, 1200)
                ->visit('/admin')
                ->clickLink('Usuarios')
                ->clickLink('Administrar usuarios')
                ->assertPathIs('/admin/usuarios')
                ->assertSee('Usuarios')
                ->pause(1000)//peticiones ajax
                ->waitForText('Siguiente')
                ->with('.table', function ($table) use ($user) {
                    $table->assertSee($user[1]->email);
                });
        });
    }

    public function testCrearUsuario()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            User::where('cedula', '00000')->delete();
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/usuarios')
                ->assertSee('Agregar Usuario')
                ->clickLink('Agregar Usuario')
                ->assertPathIs('/admin/usuarios/create')
                ->assertSee('Crear Usuario')
                ->type('name', 'John')
                ->type('lastname', 'Doe')
                ->select('PK_PAC_Id')
                ->type('cedula', '00000')
                ->type('email', 'doe@ucundinamarca.edu.co')
                ->type('password', '123456')
                ->select('PK_ESD_Id')
                ->select('roles[]')
                ->press('Crear usuario')
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Registro exitoso!');
        });
    }

    public function testModificarUsuario()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $user_a_modificar = User::where('cedula', '00000')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/usuarios')
                ->assertSee('Usuarios')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $user_a_modificar->email)
                ->pause(500)
                ->with('.table', function ($table) use ($user_a_modificar) {
                    $table
                        ->assertSee($user_a_modificar->email)
                        ->click('.edit');
                })
                ->assertPathIs('/admin/usuarios/' . $user_a_modificar->id . '/edit')
                ->assertSee('Modificar Usuario')
                ->type('name', 'Jhon')
                ->press('Modificar usuario')
                ->pause(2000)
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Usuario Modificado!');
        });
    }

    public function testEliminarUsuario()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $user_a_eliminar = User::where('cedula', '00000')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/usuarios')
                ->assertSee('Usuarios')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $user_a_eliminar->email)
                ->pause(500)
                ->with('.table', function ($table) use ($user_a_eliminar) {
                    $table
                        ->click('.remove');
                })
                ->whenAvailable('.swal2-container', function ($modal) {
                    $modal->assertSee('Esta seguro?')
                        ->press('Si, eliminar!');
                })
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Usuario Eliminado!');
        });

    }
}
