{{-- 
    parámetros:
    class -> clases que se quieran agregar al panel
    title -> titulo del panel
    settings -> opcional para maximizar pantalla, opciones generales etc.
    slot -> contenido del panel ej: forms
 --}}
<div class="x_panel {{ $class_table_1 or '' }}">
    <div class="x_title">
        @if (isset($title_table_1))
            <h2>
                {{ $title_table_1 }}
            </h2>
        @endif
        <ul class="nav navbar-right panel_toolbox">
            @if(isset($settings_table_1)) 
            <li>
                <a class="{{ $settings_table_1 }}" ><i class="fa fa-chevron-up"></i></a>
            </li>
            @endif
        </ul>
        <div class="clearfix">
        </div>
    </div>

    <div class="x_content">
        {{ $slot }}
    </div>
</div>

<div class="x_panel {{ $class_table_2 or '' }}">
    <div class="x_title">
        @if (isset($title_table_2))
            <h2>
                {{ $title_table_2 }}
            </h2>
        @endif
        <ul class="nav navbar-right panel_toolbox">
            @if(isset($settings_table_2)) 
            <li>
                <a class="{{ $settings_table_2 }}" ><i class="fa fa-chevron-up"></i></a>
            </li>
            @endif
        </ul>
        <div class="clearfix">
        </div>
    </div>

    <div class="x_content">
        {{ $slot }}
    </div>
</div>