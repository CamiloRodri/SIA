<?php

use App\Models\Autoevaluacion\DatosEncuesta;
use Illuminate\Database\Seeder;

class DatosEncuestaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatosEncuesta::insert([
            ['DAE_Titulo' => 'BIENVENIDO - ENCUESTA DE AUTOEVALUACION DIRIGIDA A ESTUDIANTES', 'DAE_Descripcion' => 'Apreciado estudiante, mediante la presente encuesta la Universidad de Cundinamarca busca recopilar información importante que contribuya a la mejora del programa que Usted estudia y la Institucion en general. Su opinion es muy valiosa para el mejoramiento, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anonima y los resultados se analizaran de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '1'],
            ['DAE_Titulo' => 'BIENVENIDO - ENCUESTA DE AUTOEVALUACION DIRIGIDA A DOCENTES', 'DAE_Descripcion' => 'Apreciado Docente, mediante la presente encuesta la Universidad de Cundinamarca busca recopilar informacion que contribuya a la mejora de la Institucion y del programa en cuestion. Su opinion es muy valiosa para el mejoramiento de la institucion, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anonima y los resultados se conoceran de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '2'],
            ['DAE_Titulo' => 'BIENVENIDO - ENCUESTA DE AUTOEVALUACION DIRIGIDA A DIRECTIVOS ACADEMICOS', 'DAE_Descripcion' => 'Apreciado funcionario, mediante la presente encuesta la Universidad de Cundinamarca busca recopilar informacion que contribuya a la mejora de la Institucion y los Programas Academicos que se ofertan. Su opinion es muy valiosa para el mejoramiento, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anonima y los resultados se analizaran de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '3'],
            ['DAE_Titulo' => 'BIENVENIDO - ENCUESTA DE AUTOEVALUACION DIRIGIDA A GRADUADOS', 'DAE_Descripcion' => 'Apreciado Egresado, mediante la presente encuesta la Universidad de Cundinamarca busca recopilar informacion importante que contribuya a la mejora del programa que Usted estudia y la Institucion en general. Su opinion es muy valiosa para el mejoramiento, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anonima y los resultados se analizaran de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '4'],
            ['DAE_Titulo' => 'BIENVENIDO - ENCUESTA DE AUTOEVALUACION DIRIGIDA A FUNCIONARIOS ADMINISTRATIVOS', 'DAE_Descripcion' => 'Apreciado funcionario, mediante la presente encuesta la Universidad de Cundinamarca busca recopilar informacion que contribuya a la mejora de la Institucion y los Programas Acadomicos que se ofertan. Su opinion es muy valiosa para el mejoramiento, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anonima y los resultados se analizaron de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '5'],
            ['DAE_Titulo' => 'ENCUESTA DIRIGIDA A EMPRESARIOS,LIDERES Y REPRESENTATES DE INSTITUCIONES ', 'DAE_Descripcion' => 'Apreciado Empresario, mediante la presente encuesta la Universidad de Cundinamarca busca obtener información relevante que contribuya a la mejora de los programas de formación y los servicios que ofrece la institución. Su opinión es muy valiosa para el mejoramiento, en este sentido le solicitamos dedicar el tiempo que sea necesario para contestar todas las preguntas con la mayor objetividad. Esta encuesta es completamente anónima y los resultados se analizarán de forma global. Muchas gracias.', 'FK_DAE_GruposInteres' => '6'],
        ]);
    }
}
