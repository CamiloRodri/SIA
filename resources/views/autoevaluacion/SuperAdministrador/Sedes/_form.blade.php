{!! Form::hidden('PK_SDS_Id', old('PK_SDS_Id'), ['id' => 'PK_SDS_Id']) !!}
<div class="item form-group">
    {!! Form::label('SDS_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('SDS_Nombre', old('SDS_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',      
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[2, 60]', 
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('SDS_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('SDS_Descripcion', old('SDS_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
         'required'=> 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 50]",
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id'), ['class' => 'select2 form-control',
        
        'required' => '', 'id' => 'estado',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>