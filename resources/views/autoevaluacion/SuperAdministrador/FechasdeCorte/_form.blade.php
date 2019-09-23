{!! Form::hidden('PK_FCO_Id', old('PK_FCO_Id'), ['id' => 'PK_FCO_Id']) !!}
<div class="form-group">
    {!! Form::label('PK_PCS_Id', 'Proceso', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_PCS_Id', $procesos, old('PK_PCS_Id'), ['class' => 'select2 form-control',
        
        'required' => '', 'id' => 'proceso',
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('FCO_Fecha','Fecha', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::date('FCO_Fecha', 
        old('FCO_Fecha', isset($fechacorte)?(string)$fechacorte->FCO_Fecha->format('d/m/Y'):''), 
        [ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'required' => 'required',
            'id' => 'fechacorte',
            'min' => $fechahoy
        ] ) !!}
    </div>
</div>
