<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        //Permisos Acceso mudulo
        Permission::create(['name' => 'ACCESO_USUARIOS']);
        Permission::create(['name' => 'ACCESO_MODULO_SUPERADMINISTRADOR']);
        Permission::create(['name' => 'ACCESO_MODULO_FUENTES_PRIMARIAS']);
        Permission::create(['name' => 'ACCESO_MODULO_FUENTES_SECUNDARIAS']);
        Permission::create(['name' => 'ACCESO_MODULO_EVALUADOR']);
        Permission::create(['name' => 'ACCESO_SEGURIDAD']);

        // Permisos Superadmin
        //Permisos para usuarios
        Permission::create(['name' => 'SUPERADMINISTRADOR']);
        Permission::create(['name' => 'ACCEDER_USUARIOS']);
        Permission::create(['name' => 'VER_USUARIOS']);
        Permission::create(['name' => 'CREAR_USUARIOS']);
        Permission::create(['name' => 'MODIFICAR_USUARIOS']);
        Permission::create(['name' => 'ELIMINAR_USUARIOS']);
        //Permisos para roles
        Permission::create(['name' => 'ACCEDER_ROLES']);
        Permission::create(['name' => 'VER_ROLES']);
        Permission::create(['name' => 'CREAR_ROLES']);
        Permission::create(['name' => 'MODIFICAR_ROLES']);
        Permission::create(['name' => 'ELIMINAR_ROLES']);
        //Permisos para permisos
        Permission::create(['name' => 'ACCEDER_PERMISOS']);
        Permission::create(['name' => 'VER_PERMISOS']);
        Permission::create(['name' => 'CREAR_PERMISOS']);
        Permission::create(['name' => 'MODIFICAR_PERMISOS']);
        Permission::create(['name' => 'ELIMINAR_PERMISOS']);
        //Permisos para lineamientos
        Permission::create(['name' => 'ACCESO_CNA']);
        Permission::create(['name' => 'ACCEDER_LINEAMIENTOS']);
        Permission::create(['name' => 'VER_LINEAMIENTOS']);
        Permission::create(['name' => 'CREAR_LINEAMIENTOS']);
        Permission::create(['name' => 'MODIFICAR_LINEAMIENTOS']);
        Permission::create(['name' => 'ELIMINAR_LINEAMIENTOS']);
        //Permisos para aspectos
        Permission::create(['name' => 'ACCEDER_ASPECTOS']);
        Permission::create(['name' => 'VER_ASPECTOS']);
        Permission::create(['name' => 'CREAR_ASPECTOS']);
        Permission::create(['name' => 'MODIFICAR_ASPECTOS']);
        Permission::create(['name' => 'ELIMINAR_ASPECTOS']);
        //Permisos para institucion
        Permission::create(['name' => 'ACCEDER_INSTITUCION']);
        Permission::create(['name' => 'VER_INSTITUCION']);
        Permission::create(['name' => 'CREAR_INSTITUCION']);
        Permission::create(['name' => 'MODIFICAR_INSTITUCION']);
        Permission::create(['name' => 'ELIMINAR_INSTITUCION']);
        //Permisos para sedes
        Permission::create(['name' => 'ACCEDER_SEDES']);
        Permission::create(['name' => 'VER_SEDES']);
        Permission::create(['name' => 'CREAR_SEDES']);
        Permission::create(['name' => 'MODIFICAR_SEDES']);
        Permission::create(['name' => 'ELIMINAR_SEDES']);
        //Permisos para facultades
        Permission::create(['name' => 'ACCEDER_FACULTADES']);
        Permission::create(['name' => 'VER_FACULTADES']);
        Permission::create(['name' => 'CREAR_FACULTADES']);
        Permission::create(['name' => 'MODIFICAR_FACULTADES']);
        Permission::create(['name' => 'ELIMINAR_FACULTADES']);
        //Permisos para programas academicos
        Permission::create(['name' => 'ACCEDER_PROGRAMAS_ACADEMICOS']);
        Permission::create(['name' => 'VER_PROGRAMAS_ACADEMICOS']);
        Permission::create(['name' => 'CREAR_PROGRAMAS_ACADEMICOS']);
        Permission::create(['name' => 'MODIFICAR_PROGRAMAS_ACADEMICOS']);
        Permission::create(['name' => 'ELIMINAR_PROGRAMAS_ACADEMICOS']);
        //Permisos para proceso para programas
        Permission::create(['name' => 'ACCEDER_PROCESOS_PROGRAMAS']);
        Permission::create(['name' => 'ASIGNAR_PROCESOS_PROGRAMAS_USUARIOS']);
        Permission::create(['name' => 'VER_PROCESOS_PROGRAMAS']);
        Permission::create(['name' => 'CREAR_PROCESOS_PROGRAMAS']);
        Permission::create(['name' => 'MODIFICAR_PROCESOS_PROGRAMAS']);
        Permission::create(['name' => 'ELIMINAR_PROCESOS_PROGRAMAS']);
        //Permisos para procesos institucionales
        Permission::create(['name' => 'ACCEDER_PROCESOS_INSTITUCIONALES']);
        Permission::create(['name' => 'ASIGNAR_PROCESOS_INSTITUCIONALES_USUARIOS']);
        Permission::create(['name' => 'VER_PROCESOS_INSTITUCIONALES']);
        Permission::create(['name' => 'CREAR_PROCESOS_INSTITUCIONALES']);
        Permission::create(['name' => 'MODIFICAR_PROCESOS_INSTITUCIONALES']);
        Permission::create(['name' => 'ELIMINAR_PROCESOS_INSTITUCIONALES']);
        //Permisos para grupos de interes
        Permission::create(['name' => 'ACCEDER_GRUPOS_INTERES']);
        Permission::create(['name' => 'VER_GRUPOS_INTERES']);
        Permission::create(['name' => 'CREAR_GRUPOS_INTERES']);
        Permission::create(['name' => 'MODIFICAR_GRUPOS_INTERES']);
        Permission::create(['name' => 'ELIMINAR_GRUPOS_INTERES']);
        //Permisos para Responsables
        Permission::create(['name' => 'ACCEDER_RESPONSABLES']);
        Permission::create(['name' => 'VER_RESPONSABLES']);
        Permission::create(['name' => 'CREAR_RESPONSABLES']);
        Permission::create(['name' => 'MODIFICAR_RESPONSABLES']);
        Permission::create(['name' => 'ELIMINAR_RESPONSABLES']);
        //Permisos para Actividades de mejoramiento
        Permission::create(['name' => 'ACCESO_PLAN_MEJORAMIENTO']);
        Permission::create(['name' => 'ACCEDER_ACTIVIDADES_MEJORAMIENTO']);
        Permission::create(['name' => 'VER_ACTIVIDADES_MEJORAMIENTO']);
        Permission::create(['name' => 'CREAR_ACTIVIDADES_MEJORAMIENTO']);
        Permission::create(['name' => 'MODIFICAR_ACTIVIDADES_MEJORAMIENTO']);
        Permission::create(['name' => 'ELIMINAR_ACTIVIDADES_MEJORAMIENTO']);
        //Permisos para fechas de corte
        Permission::create(['name' => 'ACCESO_FECHA_CORTE']);
        Permission::create(['name' => 'ACCEDER_FECHA_CORTE']);
        Permission::create(['name' => 'VER_FECHA_CORTE']);
        Permission::create(['name' => 'CREAR_FECHA_CORTE']);
        Permission::create(['name' => 'MODIFICAR_FECHA_CORTE']);
        Permission::create(['name' => 'ELIMINAR_FECHA_CORTE']);
        //Permisos para valorizacion de caracteristicas 
        Permission::create(['name' => 'ACCEDER_VALORIZACION_CARACTERISTICAS']);
        Permission::create(['name' => 'VER_VALORIZACION_CARACTERISTICAS']);


        // Permisos Fuentes primarias
        Permission::create(['name' => 'ACCEDER_ENCUESTAS']);
        Permission::create(['name' => 'VER_ENCUESTAS']);
        Permission::create(['name' => 'CREAR_ENCUESTAS']);
        Permission::create(['name' => 'MODIFICAR_ENCUESTAS']);
        Permission::create(['name' => 'ELIMINAR_ENCUESTAS']);
        //permisos banco encuestas
        Permission::create(['name' => 'ACCEDER_BANCO_ENCUESTAS']);
        Permission::create(['name' => 'VER_BANCO_ENCUESTAS']);
        Permission::create(['name' => 'CREAR_BANCO_ENCUESTAS']);
        Permission::create(['name' => 'MODIFICAR_BANCO_ENCUESTAS']);
        Permission::create(['name' => 'ELIMINAR_BANCO_ENCUESTAS']);
        // Permisos para datos especificos encuestas
        Permission::create(['name' => 'ACCEDER_DATOS']);
        Permission::create(['name' => 'VER_DATOS']);
        Permission::create(['name' => 'MODIFICAR_DATOS']);
        Permission::create(['name' => 'ELIMINAR_DATOS']);
        Permission::create(['name' => 'CREAR_DATOS']);
        // Permisos para datos establecer preguntas
        Permission::create(['name' => 'ACCEDER_ESTABLECER_PREGUNTAS']);
        Permission::create(['name' => 'VER_ESTABLECER_PREGUNTAS']);
        Permission::create(['name' => 'MODIFICAR_ESTABLECER_PREGUNTAS']);
        Permission::create(['name' => 'ELIMINAR_ESTABLECER_PREGUNTAS']);
        Permission::create(['name' => 'CREAR_ESTABLECER_PREGUNTAS']);
        // Permisos para datos establecer preguntas
        Permission::create(['name' => 'ACCEDER_IMPORTAR_PREGUNTAS']);
        Permission::create(['name' => 'IMPORTAR_PREGUNTAS']);
        // Permisos para tipo de respuestas
        Permission::create(['name' => 'ACCEDER_TIPO_RESPUESTAS']);
        Permission::create(['name' => 'VER_TIPO_RESPUESTAS']);
        Permission::create(['name' => 'MODIFICAR_TIPO_RESPUESTAS']);
        Permission::create(['name' => 'ELIMINAR_TIPO_RESPUESTAS']);
        Permission::create(['name' => 'CREAR_TIPO_RESPUESTAS']);
        // Permisos para ponderacion de respuestas
        Permission::create(['name' => 'ACCEDER_PONDERACION_RESPUESTAS']);
        Permission::create(['name' => 'VER_PONDERACION_RESPUESTAS']);
        Permission::create(['name' => 'MODIFICAR_PONDERACION_RESPUESTAS']);
        Permission::create(['name' => 'ELIMINAR_PONDERACION_RESPUESTAS']);
        Permission::create(['name' => 'CREAR_PONDERACION_RESPUESTAS']);
        // Permisos para preguntas
        Permission::create(['name' => 'ACCEDER_PREGUNTAS']);
        Permission::create(['name' => 'VER_PREGUNTAS']);
        Permission::create(['name' => 'MODIFICAR_PREGUNTAS']);
        Permission::create(['name' => 'ELIMINAR_PREGUNTAS']);
        Permission::create(['name' => 'CREAR_PREGUNTAS']);
        // Permisos para respuestas
        Permission::create(['name' => 'ACCEDER_RESPUESTAS']);
        Permission::create(['name' => 'VER_RESPUESTAS']);
        Permission::create(['name' => 'MODIFICAR_RESPUESTAS']);
        Permission::create(['name' => 'ELIMINAR_RESPUESTAS']);
        Permission::create(['name' => 'CREAR_RESPUESTAS']);
         // Permisos para respuestas
        Permission::create(['name' => 'ACCEDER_RESULTADOS']);
        Permission::create(['name' => 'VER_RESULTADOS']);



        // Permisos Fuentes secundarias
        Permission::create(['name' => 'ACCEDER_DEPENDENCIAS']);
        Permission::create(['name' => 'VER_DEPENDENCIAS']);
        Permission::create(['name' => 'CREAR_DEPENDENCIAS']);
        Permission::create(['name' => 'MODIFICAR_DEPENDENCIAS']);
        Permission::create(['name' => 'ELIMINAR_DEPENDENCIAS']);
        //permisos para grupos de documentos
        Permission::create(['name' => 'ACCEDER_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'VER_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'CREAR_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'MODIFICAR_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'ELIMINAR_GRUPO_DOCUMENTOS']);
        //permisos para factores
        Permission::create(['name' => 'ACCEDER_FACTORES']);
        Permission::create(['name' => 'VER_FACTORES']);
        Permission::create(['name' => 'CREAR_FACTORES']);
        Permission::create(['name' => 'MODIFICAR_FACTORES']);
        Permission::create(['name' => 'ELIMINAR_FACTORES']);
        //permisos tipo documento
        Permission::create(['name' => 'ACCEDER_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'VER_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'ELIMINAR_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'CREAR_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'MODIFICAR_TIPO_DOCUMENTO']);
        //permisos caracteristicas
        Permission::create(['name' => 'ACCEDER_CARACTERISTICAS']);
        Permission::create(['name' => 'VER_CARACTERISTICAS']);
        Permission::create(['name' => 'CREAR_CARACTERISTICAS']);
        Permission::create(['name' => 'MODIFICAR_CARACTERISTICAS']);
        Permission::create(['name' => 'ELIMINAR_CARACTERISTICAS']);
        //permisos ambitos
        Permission::create(['name' => 'ACCEDER_AMBITOS']);
        Permission::create(['name' => 'VER_AMBITOS']);
        Permission::create(['name' => 'CREAR_AMBITOS']);
        Permission::create(['name' => 'MODIFICAR_AMBITOS']);
        Permission::create(['name' => 'ELIMINAR_AMBITOS']);
        //Permisos para indicadores documentales
        Permission::create(['name' => 'ACCEDER_INDICADORES_DOCUMENTALES']);
        Permission::create(['name' => 'VER_INDICADORES_DOCUMENTALES']);
        Permission::create(['name' => 'CREAR_INDICADORES_DOCUMENTALES']);
        Permission::create(['name' => 'MODIFICAR_INDICADORES_DOCUMENTALES']);
        Permission::create(['name' => 'ELIMINAR_INDICADORES_DOCUMENTALES']);
        //Permisos para documentos de autoevaluación
        Permission::create(['name' => 'ACCEDER_DOCUMENTOS_AUTOEVALUACION']);
        Permission::create(['name' => 'VER_DOCUMENTOS_AUTOEVALUACION']);
        Permission::create(['name' => 'CREAR_DOCUMENTOS_AUTOEVALUACION']);
        Permission::create(['name' => 'MODIFICAR_DOCUMENTOS_AUTOEVALUACION']);
        Permission::create(['name' => 'ELIMINAR_DOCUMENTOS_AUTOEVALUACION']);
        //Permisos para documentos institucionales
        Permission::create(['name' => 'ACCEDER_DOCUMENTOS_INSTITUCIONALES']);
        Permission::create(['name' => 'VER_DOCUMENTOS_INSTITUCIONALES']);
        Permission::create(['name' => 'CREAR_DOCUMENTOS_INSTITUCIONALES']);
        Permission::create(['name' => 'MODIFICAR_DOCUMENTOS_INSTITUCIONALES']);
        Permission::create(['name' => 'ELIMINAR_DOCUMENTOS_INSTITUCIONALES']);
        Permission::create(['name' => 'EVALUAR_DOCUMENTOS_AUTOEVALUACION']);
        //Permisos para Informes
        Permission::create(['name' => 'ACCEDER_INFORMES_FUENTES_SECUNDARIAS']);
        Permission::create(['name' => 'ACCEDER_INFORMES_DOCUMENTOS_AUTOEVALUACION']);
        Permission::create(['name' => 'ACCEDER_INFORMES_DOCUMENTOS_INSTITUCIONALES']);
        
    }
}
