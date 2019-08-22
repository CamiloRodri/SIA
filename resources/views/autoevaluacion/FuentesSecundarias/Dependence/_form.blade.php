{!! Form::hidden('PK_DPC_Id', old('PK_DPC_Id'), ['id' => 'PK_DPC_Id']) !!}
<div class="item form-group">
    {!! Form::label('DPC_Nombre','Nombre', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DPC_Nombre', old('DPC_Nombre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
            'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Formato erroneo',
            'data-parsley-length' => "[5, 80]",
            'data-parsley-length-message' => 'ingrese minimo 5 caracteres',
            'data-parsley-trigger'=>"change" ]) !!}

    </div>
</div>

