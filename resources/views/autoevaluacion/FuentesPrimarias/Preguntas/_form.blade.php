@include('autoevaluacion.FuentesPrimarias.Preguntas.form_general')

@foreach($respuestas as $respuesta)
    <div class="form-group">
        {!! Form::label('PK_RPG_Id', 'Respuesta', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-4 col-sm-3 col-xs-12">
            {!! Form::textarea($respuesta->PK_RPG_Id,$respuesta->RPG_Texto,
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
            => 'required', 'data-parsley-trigger'=>"change" ] ) !!}
        </div>
        {!! Form::label('PK_PRT_Id','Ponderacion', ['class'=>'control-label col-md-1 col-sm-1 col-xs-12']) !!}
        <div class="col-md-1 col-sm- col-xs-17">
            {!! Form::select('ponderaciones[]', $ponderaciones, old('PK_PRT_Id', isset($pregunta)? $respuesta->FK_RPG_PonderacionRespuesta:''), ['class' => 'select2 form-control',
            'required' => '', 'id' => 'estado',
            'style' => 'width:100%'
            ])
            !!}
        </div>
    </div>
@endforeach    



