<?php

namespace Tests\Browser;

use App\Models\Autoevaluacion\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->visit('/login')
                ->assertSee('LOGIN')
                ->type('email', $user->email)
                ->type('password', '123456')
                ->press('Ingresar')
                ->assertPathIs('/admin');
        });
    }
}
