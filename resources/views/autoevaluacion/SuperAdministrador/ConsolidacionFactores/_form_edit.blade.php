<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', $factores, old('PK_FCT_Id', isset($consolidacion)? $consolidacion->caracteristica->factor()->pluck('PK_FCT_Id',
        'FCT_Nombre'): ''), [ 'placeholder' => 'Seleccione un factor',
         'class' => 'select2 form-control', 'required' => '', 'id' => 'factor'])
        !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[], old('PK_CRT_Id', 
        isset($consolidacion)? $consolidacion->FK_CNS_Caracteristica: ''),
         ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 'required'
        => '', 'id' => 'caracteristica']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('CNS_Fortaleza','Fortaleza', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('CNS_Fortaleza', old('CNS_Fortaleza'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('CNS_Debilidad','Debilidad', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('CNS_Debilidad', old('CNS_Debilidad'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>