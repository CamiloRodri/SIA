{!! Form::hidden('PK_TRP_Id', old('PK_TRP_Id'), ['id' => 'PK_TRP_Id']) !!}
<div class="item form-group">
    {!! Form::label('TRP_TotalPonderacion','Ponderacion Total', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('TRP_TotalPonderacion', old('TRP_TotalPonderacion'),['readonly','class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-length'=>'[1, 60]', 'data-parsley-pattern' => '^[0-9]*$',
        'id' => 'TotalPonderaciones',
        'data-parsley-pattern-message' => 'Digite un número valido','data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('TRP_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('TRP_Descripcion', old('TRP_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required'=> 'required', 'data-parsley-length'=>'[1, 5000]',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;():ñÑáéíóúÁÉÍÓÚ ]+$',
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id', isset($respuesta)? $respuesta->FK_TRP_Estado:''), ['class' => 'select2 form-control',
        'required' => '', 'id' => 'estado',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>
