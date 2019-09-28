{!! Form::hidden('PK_CNS_Id', old('PK_CNS_Id'), ['id' => 'PK_CNS_Id']) !!}

<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-8 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', $factores, old('PK_FCT_Id', isset($indicador)? $indicador->caracteristica->factor()->pluck('PK_FCT_Id','FCT_Nombre'): ''),
        ['class' => 'select2 form-control', 
        'placeholder' => 'Seleccione un factor', 'required' => '', 'id' => 'factor'])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-8 col-sm-6 col-xs-12">
        {{-- {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[], old('PK_CRT_Id', isset($indicador)? $indicador->FK_CNS_Caracteristica: ''), --}}
         {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[], old('PK_CRT_Id', isset($indicador)? $indicador->caracteristica->pluck('PK_CRT_Id','CRT_Nombre'): ''),
         ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 'required'
        => '', 'id' => 'caracteristica']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('CNS_Fortaleza','Fortaleza', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-8 col-sm-6 col-xs-12">
        {!! Form::textarea('CNS_Fortaleza', old('CNS_Fortaleza'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5, 200]',
        'rows' => '3',
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('CNS_Debilidad','Debilidad', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-8 col-sm-6 col-xs-12">
        {!! Form::textarea('CNS_Debilidad', old('CNS_Debilidad'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5, 200]',
        'rows' => '3',
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
