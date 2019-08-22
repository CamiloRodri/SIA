<?php

namespace Tests\Browser;

use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LineamientoTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testVerLineamientos()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $lineamientos = Lineamiento::all();
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin')
                ->clickLink('Super administrador')
                ->clickLink('CNA')
                ->clickLink('Lineamiento')
                ->assertPathIs('/admin/lineamientos')
                ->assertSee('Lineamientos')
                ->pause(1000)//peticiones ajax
                ->waitForText('Siguiente')
                ->with('.table', function ($table) use ($lineamientos) {
                    $table->assertSee($lineamientos[0]->LNM_Nombre);
                });
        });
    }

    public function testCrearLineamiento()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/lineamientos')
                ->assertSee('Agregar Lineamiento')
                ->clickLink('Agregar Lineamiento')
                ->assertPathIs('/admin/lineamientos/create')
                ->assertSee('Crear Lineamiento')
                ->type('LNM_Nombre', 'Postgrado')
                ->type('LNM_Descripcion', 'La descripcion')
                ->press('Crear Lineamiento')
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Registro exitoso!');
        });
    }

    public function testModificarLineamiento()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $lineamiento_a_modificar = Lineamiento::where('LNM_Nombre', 'postgrado')->first();
            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/lineamientos')
                ->assertSee('Lineamiento')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $lineamiento_a_modificar->LNM_Nombre)
                ->pause(500)
                ->with('.table', function ($table) use ($lineamiento_a_modificar) {
                    $table
                        ->assertSee($lineamiento_a_modificar->LNM_Nombre)
                        ->click('.edit');
                })
                ->assertPathIs('/admin/lineamientos/' . $lineamiento_a_modificar->PK_LNM_Id . '/edit')
                ->assertSee('Modificar Lineamiento')
                ->type('LNM_Descripcion', 'La super descripción')
                ->press('Modificar Lineamiento')
                ->pause(2000)
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Lineamiento Modificado!');
        });
    }

    public function testEliminarLineamiento()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $lineamiento_a_eliminar = Lineamiento::where('LNM_Nombre', 'postgrado')->first();

            $browser
                ->loginAs($user)
                ->resize(1300, 1200)
                ->visit('/admin/lineamientos')
                ->assertSee('Lineamientos')
                ->pause(500)//peticiones ajax
                ->waitForText('Siguiente')
                ->waitForText('Buscar')
                ->type('input[type=search]', $lineamiento_a_eliminar->LNM_Nombre)
                ->pause(500)
                ->with('.table', function ($table) use ($lineamiento_a_eliminar) {
                    $table
                        ->click('.remove');
                })
                ->whenAvailable('.swal2-container', function ($modal) {
                    $modal->assertSee('Esta seguro?')
                        ->press('Si, eliminar!');
                })
                ->waitFor('.ui-pnotify-title')
                ->assertSee('¡Lineamiento Eliminado!');
        });
    }
}
