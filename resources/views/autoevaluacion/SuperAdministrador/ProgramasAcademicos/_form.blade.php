<div class="form-group">
    {!! Form::label('PK_SDS_Id', 'Sede', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">

        {!! Form::select('PK_SDS_Id', $sedes, old('PK_SDS_Id', 
        isset($programaAcademico)? $programaAcademico->FK_PAC_Sede: ''), [ 'placeholder' => 'Seleccione una sede',
         'class' => 'select2 form-control', 'required' => '', 'id' => 'sede'])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PK_FCD_Id', 'Facultad', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCD_Id', $facultades, 
        old('PK_FCD_Id', isset($programaAcademico)? $programaAcademico->FK_PAC_Facultad: ''), 
        ['class' => 'select2 form-control','placeholder' => 'Seleccione una facultad', 'required'
        => '', 'id' => 'facultad']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ESD_Id', $estados, 
        old('PK_ESD_Id', isset($programaAcademico)? $programaAcademico->FK_PAC_Estado: ''), 
        ['class' => 'select2 form-control','placeholder' => 'Seleccione un estado', 'required'
        => '', 'id' => 'estado']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Nombre', old('PAC_Nombre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PAC_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('PAC_Descripcion', old('PAC_Descripcion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required'
        => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,100]',
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>