<li><a><i class="fa fa-info-circle"></i> Fuentes Primarias <span class="fa fa-chevron-down"></span></a>

    <ul class="nav child_menu">
        <li><a><i class="fa fa-file"></i>Encuestas<span class="fa fa-chevron-down"></span> </a>

            <ul class="nav child_menu">
                @can('ACCEDER_DATOS')
                    <li class="sub_menu"><a href="{{ route('fuentesP.datosEncuestas.index') }}"><i
                                    class="fa fa-plus-square-o"></i>Datos Generales</a>
                    </li>
                @endcan
                @can('ACCEDER_BANCO_ENCUESTAS')
                    <li class="sub_menu"><a href="{{ route('fuentesP.bancoEncuestas.index') }}"><i
                                    class="fa fa-paste"></i>Banco de Encuestas</a>
                    </li>
                @endcan
                @can('ACCEDER_ENCUESTAS')
                    <li class="sub_menu"><a href="{{ route('fuentesP.datosEspecificos.index') }}"><i
                                    class="fa fa-external-link"></i>Vincular Encuestas</a>
                    </li>
                @endcan
            </ul>
        </li>

        @can('ACCEDER_PREGUNTAS')
            <li><a href="{{ route('fuentesP.preguntas.index') }}"><i class="fa fa-question-circle"></i>Banco de
                    Preguntas</a>
            </li>
        @endcan

        @can('ACCEDER_TIPO_RESPUESTAS')
            <li><a href="{{ route('fuentesP.tipoRespuesta.index') }}"><i class="fa fa-pencil-square"></i>
                    Tipo de Respuestas </a>
            </li>
        @endcan
        <li><a href="{{ route('primarias.informe_encuestas') }}"><i class="fa fa-bar-chart"></i>
                Informes </a>
        </li>
        @can('ACCEDER_RESULTADOS')
         <li><a href="{{ route('fuentesP.resultados.index') }}"><i class="fa fa-table"></i>
                Resultados </a>
        </li>
        @endcan
    </ul>
</li>             