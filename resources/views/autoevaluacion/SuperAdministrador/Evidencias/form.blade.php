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
{{-- <div class="form-group">
    {!! Form::label('EVD_Fecha_Subido','Fecha de Subida', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Fecha_Subido', old('EVD_Fecha_Subido'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div> --}}
<div class="form-group">
    {!! Form::label('EVD_Descripcion_General','Decripción General', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('EVD_Descripcion_General', old('EVD_Descripcion_General'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div>

{{-- <div class="form-group">
    {!! Form::label('FK_EVD_Actividad_Mejoramiento','Actividad', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FK_EVD_Actividad_Mejoramiento', old('FK_EVD_Actividad_Mejoramiento'), [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5, 60]', 'data-parsley-trigger'=>"change" ] ) 
        !!}
    </div>
</div> --}}

{{ Form::hidden('FK_EVD_Actividad_Mejoramiento', $actividad->PK_ACM_Id) }}