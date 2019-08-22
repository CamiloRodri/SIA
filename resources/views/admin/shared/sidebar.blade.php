<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('admin.home')}}" class="site_title"><i class="fa fa-book"></i>
                <span>{{ config('app.name') }}</span></a>
        </div>
        <!-- menu profile quick info -->
    @include('admin.shared.menuProfile')
    <!-- /menu profile quick info -->

        <br/>

        <div class="clearfix"></div>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('admin.home')}}"><i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    @can('ACCESO_MODULO_SUPERADMINISTRADOR')
                        @include('admin.shared.menuSidebar.superAdmin')
                    @endcan
                    @can('ACCESO_MODULO_FUENTES_PRIMARIAS')
                        @include('admin.shared.menuSidebar.fuentesPrimarias')
                    @endcan
                    @can('ACCESO_MODULO_FUENTES_SECUNDARIAS')
                        @include('admin.shared.menuSidebar.fuentesSecundarias')
                    @endcan
                    <li>
                        <a href="{{ route('admin.historial')}}">
                            <i class="fa fa-history"></i> Historial
                        </a>
                    </li>
                    @can('ACCESO_SEGURIDAD')
                    <li>
                        <a href="{{ route('admin.seguridad')}}">
                            <i class="fa fa-cogs"></i> Seguridad
                        </a>
                    </li>
                    @endcan

                </ul>
            </div>


        </div>
    </div>
</div>
