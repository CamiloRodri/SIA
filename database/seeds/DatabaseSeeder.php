<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EstadosTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FasesTableSeeder::class);
        $this->call(DependenciasTableSeeder::class);
        $this->call(TipoDocumentosTableSeeder::class);
        $this->call(GruposInteresTableSeeder::class);
        $this->call(DatosEncuestaTableSeeder::class);
        $this->call(GrupoDocumentoTableSeeder::class);
        $this->call(AlcancesAdministrativosTableSeeder::class);
        $this->call(CargosAdministrativosTableSeeder::class);

    }
}
