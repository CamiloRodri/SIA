{!! Form::hidden('id', old('id'), ['id' => 'id']) !!}
<div class="item form-group">
    {!! Form::label('name','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('name', old('TDO_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
         'data-parsley-length'=>'[5, 50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>