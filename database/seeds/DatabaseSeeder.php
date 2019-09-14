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
        $this->truncateTables([
            'users', 'activity_log', 'TBL_Instituciones', 'model_has_permissions', 'model_has_roles', 'password_resets', 'permissions', 'roles', 'role_has_permissions', 'TBL_Actividades',
            'TBL_Actividades_Mejoramiento', 'TBL_Alcances_Administrativos', 'TBL_Ambitos_Responsabilidad', 'TBL_Archivos', 'TBL_Aspectos', 'TBL_Banco_Encuestas', 'TBL_Caracteristicas', 
            'TBL_Cargos_Administrativos', 'TBL_Datos_Encuestas', 'TBL_Dependencias', 'TBL_Documentos_Autoevaluacion', 'TBL_Documentos_Institucionales', 'TBL_Encuestas', 'TBL_Encuestados', 
            'TBL_Encuestas', 'TBL_Estados' , 'TBL_Factores', 'TBL_Facultades', 'TBL_Fases', 'TBL_Grupos', 'TBL_Grupos_Documentos', 'TBL_Grupos_Interes', 'TBL_Indicadores', 'TBL_Indicadores_Documentales',
            'TBL_Lineamientos', 'TBL_Modulos', 'TBL_Plan_de_Mejoramiento', 'TBL_Ponderacion_Respuestas', 'TBL_Preguntas', 'TBL_Preguntas_Encuestas', 'TBL_Procesos', 'TBL_Procesos_Usuarios',
            'TBL_Programas_Academicos', 'TBL_Responsables', 'TBL_Respuestas_Preguntas', 'TBL_Sedes', 'TBL_Solucion_Encuestas', 'TBL_Subgrupos', 'TBL_Tipo_Documentos', 'TBL_Tipo_Respuestas', 
            'TBL_Usuarios', 'TBL_Metodologias', 'TBL_Frentes_Estrategicos','TBL_Fechas_corte'
        ]);

        $this->call(EstadosTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FasesTableSeeder::class);
        $this->call(DependenciasTableSeeder::class);
        $this->call(TipoDocumentosTableSeeder::class);
        $this->call(GruposInteresTableSeeder::class);
        $this->call(MetodologiasSeeder::class);
        $this->call(DatosEncuestaTableSeeder::class);
        $this->call(GrupoDocumentoTableSeeder::class);
        $this->call(AlcancesAdministrativosTableSeeder::class);
        $this->call(CargosAdministrativosTableSeeder::class);

        }

        protected function truncateTables(array $tables)
        {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }
}
