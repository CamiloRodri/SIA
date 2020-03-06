{!! Form::hidden('PK_AMB_Id', old('PK_AMB_Id'), ['id' => 'PK_AMB_Id']) !!}
<div class="item form-group">
    {!! Form::label('CLA_Calificacion','Calificación', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('CLA_Calificacion', old(' {{ $calificacion->CLA_Calificacion }} '),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[0, 60]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('CLA_Observacion','Observación', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('CLA_Observacion', old('CLA_Observacion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
         'required'=> 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 50]",
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

{{ Form::hidden('FK_CLA_Actividad_Mejoramiento', $actividad->PK_ACM_Id) }}
