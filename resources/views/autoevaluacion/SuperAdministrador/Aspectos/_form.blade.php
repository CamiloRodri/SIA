<div class="item form-group">
    {!! Form::label('PK_LNM_Id', 'Lineamiento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_LNM_Id', $lineamientos, old('PK_LNM_Id', isset($aspecto)? 
        $aspecto->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id', 'LNM_Nombre'): ''), [
            'placeholder' => 'Seleccione un lineamiento',
            'class' => 'select2 form-control',
            'id' => 'lineamiento']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factores)?$factores:[], old('PK_FCT_Id', isset($aspecto)? 
        $aspecto->caracteristica->factor()->pluck('PK_FCT_Id', 'FCT_Nombre'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un factor',
        'id' => 'factor']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[],
         old('PK_CRT_Id', isset($aspecto)? $aspecto->FK_ASP_Caracteristica
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 
        'required' => '',
        'id' => 'caracteristica']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ASP_Identificador','Identificador', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ASP_Identificador', old('ASP_Identificador'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]", 
         'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ASP_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ASP_Nombre', old('ASP_Nombre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5, 330]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ASP_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('ASP_Descripcion', old('ASP_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length' => "[1, 250]", 
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>