@include('autoevaluacion.SuperAdministrador.Instituciones.form_general')

@foreach($frenteEstrategicos as $frenteEstrategico)
    <div class="form-group">
        {!! Form::label('PK_FES_Nombre', 'Frente Estrategico', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-4 col-sm-3 col-xs-12">
            {!! Form::text($frenteEstrategico->PK_FES_Nombre,$frenteEstrategico->FES_Nombre,
                [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
                => 'required', 'data-parsley-trigger'=>"change" ] ) 
            !!}
        </div><br>
    </div>
    <div class="form-group">
        {!! Form::label('PK_FES_Descripcion', 'Descripcion', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-4 col-sm-3 col-xs-12">
            {!! Form::textarea($frenteEstrategico->PK_FES_Descripcion,$frenteEstrategico->FES_Descripcion,
                [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
                => 'required', 'data-parsley-trigger'=>"change" ] ) 
            !!}
        </div>
    </div>
@endforeach    



