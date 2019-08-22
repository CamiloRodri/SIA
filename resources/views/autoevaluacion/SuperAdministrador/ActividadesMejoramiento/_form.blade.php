<div class="item form-group">
    {!! Form::label('ACM_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ACM_Nombre', old('ACM_Nombre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ACM_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('ACM_Descripcion', old('ACM_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 3000]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ACM_Fecha_Inicio','Fecha de Incio', ['class'=>'control-label col-md-5 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-9 col-xs-5">
        {!! Form::text('ACM_Fecha_Inicio',
        old('ACM_Fecha_Inicio', isset($actividades)?(string)$actividades->ACM_Fecha_Inicio->format('d/m/Y'):''), 
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_inicio'
        ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ACM_Fecha_Fin','Fecha de Finalizacion', ['class'=>'control-label col-md-5 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-9 col-xs-5">
        {!! Form::text('ACM_Fecha_Fin', 
        old('ACM_Fecha_Fin',isset($actividades)?(string)$actividades->ACM_Fecha_Fin->format('d/m/Y'):''),
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_fin'
        ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_RPS_Id', 'Responsable', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_RPS_Id', $responsable, old('PK_BEC_Id',isset($actividades)? $actividades->responsable->PK_RPS_Id
        : ''), 
        ['class' => 'select2 form-control',
        'required' => '', 'id' => 'responsable',
        'placeholder' => 'Seleccione un responsable',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

