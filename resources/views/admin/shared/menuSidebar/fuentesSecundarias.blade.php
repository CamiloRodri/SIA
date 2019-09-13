<li><a><i class="fa fa-file-text-o"></i> Fuentes Secundarias <span class="fa fa-chevron-down"></span></a>

    <ul class="nav child_menu">
        @can('ACCEDER_DEPENDENCIAS')
            <li><a href="{{ route('documental.dependencia.index') }}"><i class="fa fa-suitcase"></i>Dependencias</a>
            </li>
        @endcan
        @can('ACCEDER_INDICADORES_DOCUMENTALES')
        <li><a href="{{ route('documental.indicadores_documentales.index')}}"><i class="fa fa-list"></i>Indicadores
                Documentales</a>
        </li>
        @endcan
        <li><a><i class="fa fa-file"></i>Documentos<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                @can('ACCEDER_DOCUMENTOS_AUTOEVALUACION')
                    <li class="sub_menu"><a href="{{ route('documental.documentos_autoevaluacion.index') }}"><i
                                    class="fa fa-clipboard"></i>Documentos Autoevaluacion</a>
                    </li>
                @endcan
                @can('ACCEDER_DOCUMENTOS_INSTITUCIONALES')
                    <li><a href="{{ route('documental.documentoinstitucional.index') }}"><i class="fa fa-file-text"></i>Documentos
                            Institucionales</a>
                    </li>
                @endcan
                @can('ACCEDER_GRUPO_DOCUMENTOS')
                    <li><a href="{{ route('documental.grupodocumentos.index') }}"><i class="fa fa-briefcase"></i>Grupos
                            de
                            Documentos</a>
                    </li>
                @endcan
                @can('ACCEDER_TIPO_DOCUMENTO')
                    <li><a href="{{ route('documental.tipodocumento.index') }}"><i class="fa fa-cog"></i>Tipos de
                            Documentos</a>
                    </li>
                @endcan
            </ul>
        </li>
        @can('ACCEDER_INFORMES_FUENTES_SECUNDARIAS')
        <li><a><i class="fa fa-spinner"></i>Informes<span class="fa fa-chevron-down"></span> </a>
            <ul class="nav child_menu">
                @can('ACCEDER_INFORMES_DOCUMENTOS_AUTOEVALUACION')
                <li class="sub_menu"><a href="{{ route('documental.informe_documental') }}"><i
                                class="fa fa-list-alt"></i>Documentos Autoevaluacion</a>
                </li>
                @endcan
                @can('ACCEDER_INFORMES_DOCUMENTOS_INSTITUCIONALES')
                <li><a href="{{ route('documental.informe_documental.institucional') }}"><i class="fa fa-eye"></i>Documentos
                        Institucionales</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>