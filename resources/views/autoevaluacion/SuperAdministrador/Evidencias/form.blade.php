<div class="item form-group">
    {!! Form::label('metodologia','Metodología', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FK_ITN_Metodologia', $actividad, old('FK_ITN_Metodologia', isset($evidencia)? $evidencia->FK_ACM_Actividad_Mejoramiento:''), [
            // 'placeholder' => 'Seleccione una Metodologia',
            'class' => 'select2_user form-control', 
            'required']) 
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('EVD_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Nombre', old('EVD_Nombre'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('EVD_Link','Link', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Link', old('EVD_Link'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('EVD_Fecha_Subido','Fecha de Subida', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Fecha_Subido', old('EVD_Fecha_Subido'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('EVD_Descripcion_General','Nombre Proceso', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Descripcion_General', old('EVD_Descripcion_General'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('EVD_Descripcion_General','Nombre Proceso', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Descripcion_General', old('EVD_Descripcion_General'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>