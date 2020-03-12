@can('ACCESO_USUARIOS')
<li><a href="#"><i class="fa fa-users">
        </i> Usuarios<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        @can('ACCEDER_USUARIOS')
            <li><a href="{{ route('admin.usuarios.index') }}"><i class="fa fa-user">
                    </i>Administrar usuarios</a>
            </li>
        @endcan
        @can('ACCEDER_ROLES')
            <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-gavel">
                    </i>Roles</a>
            </li>
        @endcan
        @can('ACCEDER_PERMISOS')
            <li><a href="{{ route('admin.permisos.index') }}"><i class="fa fa-unlock">
                    </i>Permisos</a>
            </li>
        @endcan
    </ul>
</li>
@endcan
<li><a><i class="fa fa-male"></i> Super administrador <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        @can('ACCEDER_INSTITUCION')
            <li>
                <a href="{{ route('admin.institucion.index')}}"><i class="fa fa-university"></i> Institución</a>
            </li>
        @endcan
        @can('ACCEDER_SEDES')
            <li>
                <a href="{{ route('admin.sedes.index')}}"><i class="fa fa-industry"></i> Sedes</a>
            </li>
        @endcan
        @can('ACCEDER_FACULTADES')
            <li>
                <a href="{{ route('admin.facultades.index')}}"><i class="fa fa-university"></i> Facultades</a>
            </li>
        @endcan
        @can('ACCEDER_PROGRAMAS_ACADEMICOS')
            <li>
                <a href="{{ route('admin.programas_academicos.index')}}"><i class="fa fa-book"></i> Programas
                    Académicos</a>
            </li>
        @endcan
        @can('ACCEDER_PROCESOS_INSTITUCIONALES')
            <li>
                <a href="{{ route('admin.procesos_institucionales.index')}}"><i class="fa fa-building-o"></i> Procesos
                    institucionales</a>
            </li>
        @endcan
        @can('ACCEDER_PROCESOS_PROGRAMAS')
            <li>
                <a href="{{ route('admin.procesos_programas.index')}}"><i class="fa fa-graduation-cap"></i> Procesos
                    programas</a>
            </li>
        @endcan
        @can('ACCEDER_GRUPOS_INTERES')
            <li>
                <a href="{{ route('admin.grupos_interes.index')}}"><i class="fa fa-slideshare"></i> Grupos
                    de Interes</a>
            </li>
        @endcan
        @can('ACCESO_CNA')
        <li><a><i class="fa fa-bookmark"></i>CNA<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                @can('ACCEDER_LINEAMIENTOS')
                    <li class="sub_menu"><a href="{{ route('admin.lineamientos.index') }}"><i
                                    class="fa fa-line-chart"></i>Lineamiento</a>
                    </li>
                @endcan
                @can('ACCEDER_FACTORES')
                    <li class="sub_menu"><a href="{{ route('admin.factores.index') }}"><i class="fa fa-bar-chart"></i>Factor</a>
                    </li>

                @endcan
                @can('ACCEDER_AMBITOS')
                    <li class="sub_menu"><a href="{{ route('admin.ambito.index') }}"><i class="fa fa-laptop"></i>Ambito</a>
                    </li>
                    <li class="sub_menu"><a href="{{ route('admin.caracteristicas.index') }}"><i
                                    class="fa fa-sliders"></i>Caracteristicas</a>
                    </li>
                @endcan
                @can('ACCEDER_ASPECTOS')
                    <li class="sub_menu"><a href="{{ route('admin.aspectos.index') }}"><i
                                    class="fa fa-table"></i>Aspectos</a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('ACCESO_PLAN_MEJORAMIENTO')
        <li><a><i class="fa fa-star"></i>Plan de Mejoramiento<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                @can('ACCEDER_RESPONSABLES')
                    <li>
                        <a href="{{ route('admin.responsables.index')}}"><i class="fa fa-child"></i>Responsables</a>
                    </li>
                @endcan
                @can('ACCEDER_VALORIZACION_CARACTERISTICAS')
                    <li>
                        <a href="{{ route('admin.caracteristicas_mejoramiento.index')}}"><i
                                    class="fa fa-line-chart"></i> Valorizacion de Caracteristicas</a>
                    </li>
                @endcan
                @can('ACCEDER_CONSOLIDACION_FACTORES')
                    <li>
                        <a href="{{ route('admin.consolidacion_factores.index')}}"><i
                                    class="fa fa-crosshairs"></i>Consolidación de Factores</a>
                    </li>
                @endcan
                @can('ACCEDER_ACTIVIDADES_MEJORAMIENTO')
                    <li>
                        <a href="{{ route('admin.actividades_mejoramiento.index')}}"><i class="fa fa-bar-chart"></i>Actividades
                            de Mejoramiento</a>
                    </li>
                @endcan
                @can('ACCEDER_CALENDARIO_ACTIVIDADES')
                    <li>
                        <a href="{{ route('admin.calendario')}}"><i
                                    class="fa fa-calendar"></i> Calendario de Actividades</a>
                    </li>
                @endcan
                @can('ACCEDER_INFORME_AUTOEVALUACION')
                    <li>
                        <a href="{{ route('admin.informes_autoevaluacion.create')}}"><i class="fa fa-file-word-o"></i>
                        Informe Autoevaluación</a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</li>
