{{-- 
    parámetros:
    class -> clases que se quieran agregar al panel
    title -> titulo del panel
    settings -> opcional para maximizar pantalla, opciones generales etc.
    slot -> contenido del panel ej: forms
 --}}
<div class="x_panel {{ $class or '' }}">
    <div class="x_title">
        @if (isset($title))
            <h2>
                {{ $title }}
            </h2>
        @endif
        <ul class="nav navbar-right panel_toolbox">
            @if(isset($settings)) {{ $settings }} @endif
        </ul>
        <div class="clearfix">
        </div>
    </div>

    <div class="x_content">
        {{ $slot }}
    </div>
</div>