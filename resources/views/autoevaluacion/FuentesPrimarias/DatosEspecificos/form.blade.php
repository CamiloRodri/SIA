<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id'), ['class' => 'select2 form-control',
        'required' => '', 'id' => 'estado',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ECT_FechaPublicacion','Fecha Publicacion', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::text('ECT_FechaPublicacion',
        old('ECT_FechaPublicacion', isset($encuesta)?(string)$encuesta->ECT_FechaPublicacion->format('d/m/Y'):''), 
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_inicio'
        ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ECT_FechaFinalizacion','Fecha Finalizacion', ['class'=>'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::text('ECT_FechaFinalizacion', 
        old('ECT_FechaFinalizacion',isset($encuesta)?(string)$encuesta->ECT_FechaFinalizacion->format('d/m/Y'):''),
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fecha_fin'
        ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_BEC_Id', 'Encuesta', ['class' => 'control-label col-md-4 col-sm-3 col-xs-12']) !!}
    <div class="col-md-5 col-sm-9 col-xs-9">
        {!! Form::select('PK_BEC_Id', $encuestas, old('PK_BEC_Id',isset($encuesta)? $encuesta->banco->PK_BEC_Id
        : ''), 
        ['class' => 'select2 form-control',
        'required' => '', 'id' => 'encuesta',
        'placeholder' => 'Seleccione una encuesta',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::hidden('PK_PCS_Id',isset($encuesta)? $encuesta->FK_ECT_Proceso : Session::get('id_proceso')) !!}
</div>



