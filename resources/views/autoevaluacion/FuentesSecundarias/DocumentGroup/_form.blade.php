{!! Form::hidden('PK_GRD_Id', old('PK_GRD_Id'), ['id' => 'PK_GRD_Id']) !!}
<div class="item form-group">
    {!! Form::label('GRD_Nombre','Nombre', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('GRD_Nombre', old('GRD_Nombre'),[
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
            'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Por favor escriba solo letras',
            'data-parsley-length' => "[5, 50]",
            'data-parsley-length-message' => 'ingrese minimo 5 caracteres',
            'data-parsley-trigger'=>"change" ]) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('GRD_Descripcion','Descripcion', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('GRD_Descripcion', old('GRD_Descripcion'),[
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
            'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Por favor escriba solo letras',
            'data-parsley-length' => "[5, 50]",
            'data-parsley-length-message' => 'ingrese minimo 5 caracteres',
            'data-parsley-trigger'=>"change" ]) !!}

    </div>
</div>


