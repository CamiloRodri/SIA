@include('autoevaluacion.SuperAdministrador.Instituciones.form_general')

<div class="form-group">
    {!! Form::label('created_at', 'Cantidad de Frentes Estrategicos', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('created_at', $frenteEstrategicos, old('created_at'), ['class' => 'select2 form-control',
            'required' => 'required', 'id' => 'tipo',
        'placeholder' => 'Seleccione una cantidad de frentes', 
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('Frente Estrategico', '', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12" id="container">
    </div>
</div>