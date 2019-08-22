@include('autoevaluacion.FuentesPrimarias.Preguntas.form_general')

<div class="form-group">
    {!! Form::label('PK_TRP_Id', 'Cantidad Respuestas', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_TRP_Id', $tipos, old('PK_TRP_Id'), ['class' => 'select2 form-control',
            'required' => 'required', 'id' => 'tipo',
        'placeholder' => 'Seleccione una cantidad de respuestas', 
        'style' => 'width:100%'
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('Respuestas', '', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12" id="container">
    </div>
</div>
