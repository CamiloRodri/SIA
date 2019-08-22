@include('autoevaluacion.FuentesPrimarias.TipoRespuestas.form_general')

<div class="form-group">
    {!! Form::label('TRP_CantidadRespuestas','Cantidad Respuestas', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-4 col-sm-3 col-xs-12">
        {!! Form::text('TRP_CantidadRespuestas', old('TRP_CantidadRespuestas'),
        [ 'class' => 'form-control col-md-4 col-sm-3 col-xs-12', 'required'
        => 'required','data-parsley-length'=>'[1, 60]','data-parsley-pattern' => '^[0-9]*$',
        'data-parsley-pattern-message' => 'Error, digite solo numeros','data-parsley-trigger'=>"change",
        'id' => 'cantidad'  ] ) !!}
    </div>
    <div class="col-md-5 col-sm-2 col-xs-12">
        <input type="checkbox" id="ponderacion" name="ponderacion" value="1" required>Agregar Ponderaciones</br>
    </div>
</div>

<div class="form-group">
    {!! Form::label('', '', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12" id="container">
    </div>
</div>