{!! Form::hidden('PK_FES_Id', old('PK_FES_Id'), ['id' => 'PK_FES_Id']) !!}
<div class="form-group">
    {!! Form::label('FES_Nombre','Frente Estrategico', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FES_Nombre', old('FES_Nombre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]",
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('FES_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('FES_Descripcion', old('FES_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]",
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

