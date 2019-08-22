{!! Form::hidden('PK_DAE_Id', old('PK_DAE_Id'), ['id' => 'PK_DAE_Id']) !!}
<div class="item form-group">
    {!! Form::label('DAE_Titulo','Titulo', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DAE_Titulo', old('DAE_Titulo'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('DAE_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('DAE_Descripcion', old('DAE_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 3000]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PK_GIT_Id', 'Grupo de Interes', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_GIT_Id', $grupos, old('PK_GIT_Id', isset($datos)? $datos->FK_DAE_GruposInteres: ''), ['class' => 'select2 form-control',
         'id' => 'grupos',
        'style' => 'width:100%',
        'placeholder' => 'Seleccione un grupo de interes', 
        'required' => 'required', 
        ])
        !!}
    </div>
</div>
