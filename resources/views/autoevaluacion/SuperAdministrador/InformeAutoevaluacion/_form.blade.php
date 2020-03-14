<div class="item form-group">
    {!! Form::label('IAT_Titulo_Uno','Titutlo 1', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('IAT_Titulo_Uno', old('IAT_Titulo_Uno'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'placeholder' => 'NOMBRE DEL MACROPROCESO',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,100}$',
            'data-parsley-pattern-message' => 'Por favor escriba un nombre válido',
            'data-parsley-length' => "[1, 50]",
            'data-parsley-trigger'=>"change"] )
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('IAT_Titulo_Dos','Titulo 2', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('IAT_Titulo_Dos', old('IAT_Titulo_Dos'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'placeholder' => 'NOMBRE DEL PROCESO',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,100}$',
            'data-parsley-pattern-message' => 'Por favor escriba un domicilio válido',
            'data-parsley-length' => "[1, 50]",
            'data-parsley-trigger'=>"change"] )
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('IAT_Titulo_Tres','Titulo 3', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('IAT_Titulo_Tres', old('IAT_Titulo_Tres'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'placeholder' => 'GUÍA INFORME DE AUTOEVALUACIÓN DE PROGRAMAS ACADÉMICOS',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,70}$',
            'data-parsley-pattern-message' => 'Por favor escriba un titulo al encabezado válido',
            'data-parsley-length' => "[1, 50]",
            'data-parsley-trigger'=>"change"] )
        !!}
    </div>
</div>
