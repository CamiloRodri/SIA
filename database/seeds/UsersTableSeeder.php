<?php

use App\Models\Autoevaluacion\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Claudia',
            'lastname' => 'admin',
            'email' => 'claudia@ucundinamarca.edu.co',
            'password' => '123456',
            'cedula' => '123',
            'id_estado' => '1'
        ]);
        $user1->assignRole('SUPERADMIN');
        $user1->assignRole('FUENTES_PRIMARIAS');


        $user1 = User::create([
            'name' => 'Alejandro',
            'lastname' => '2',
            'email' => 'alejo@ucundinamarca.edu.co',
            'password' => '123456',
            'cedula' => '12',
            'id_estado' => '1'
        ]);
        $user1->assignRole('FUENTES_PRIMARIAS');

        $user1 = User::create([
            'name' => 'Liz',
            'lastname' => 'Quintero',
            'email' => 'liz@ucundinamarca.edu.co',
            'password' => '123456',
            'cedula' => '1221',
            'id_estado' => '1'
        ]);
        $user1->assignRole('FUENTES_SECUNDARIAS');

        $user1 = User::create([
            'name' => 'Angie',
            'lastname' => 'Lorena',
            'email' => 'an@ucundinamarca.edu.co',
            'password' => '123456',
            'cedula' => '167887',
            'id_estado' => '1'
        ]);
        $user1->assignRole('ADMIN');
    }
}
