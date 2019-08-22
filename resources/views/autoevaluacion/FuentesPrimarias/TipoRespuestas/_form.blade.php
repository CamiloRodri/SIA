@include('autoevaluacion.FuentesPrimarias.TipoRespuestas.form_general')

<div class="form-group">
    {!! Form::label('PK_PRT_Id', 'Ponderaciones', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        @foreach($ponderaciones as $ponderacion)
            <input type="text" id="{{$ponderacion->PK_PRT_Id}}" name="{{$ponderacion->PK_PRT_Id}}"
                   value="{{$ponderacion->PRT_Ponderacion}}" required
                   minLength="1" maxLength="3" class="form-control col-md-6 col-sm-6 col-xs-12"
                   pattern="^[0-9.]*$"/>
            <br></br>
        @endforeach
    </div>
</div>   