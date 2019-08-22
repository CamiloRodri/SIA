<div class="item form-group">
    {!! Form::label('FCT_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FCT_Nombre', old('FCT_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\., ]{1,50}$',
        'data-parsley-pattern-message' => 'Por favor escriba un nombre valido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('FCT_Descripcion','Descripcion', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}

    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FCT_Descripcion', old('FCT_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\., ]{1,50}$', 
        'data-parsley-pattern-message' => 'Por favor escriba una descripcion valida',
        'data-parsley-length' => "[1, 50]",
         'data-parsley-trigger'=>"change" ]) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('FCT_Identificador','Identificador', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FCT_Identificador', old('FCT_Identificador'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[0, 10]",
        'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('FCT_Ponderacion_factor','Ponderación', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('FCT_Ponderacion_factor', old('FCT_Ponderacion_factor'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[0, 10]",
        'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('estado','Estado', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_estado">
            @foreach($estados as $estado)
        <option selected="{{ isset($user)?  }}" value="{{  $estado->PK_ESD_Id }}">{{ $estado->ESD_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_FCT_Estado', $estados, old('FK_FCT_Estado', isset($user)? $user->id_estado:''), [
            'placeholder' => 'Seleccione un Estado',
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('lineamiento','Lineamiento', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_lineamiento">
            @foreach($lineamientos as $lineamiento)
        <option selected="{{ isset($user)?  }}" value="{{ $lineamiento->PK_LNM_Id }}">{{ $lineamiento->LNM_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_FCT_Lineamiento', $lineamientos, old('FK_FCT_Lineamiento', isset($user)? $user->id_lineamiento:''), [
            'placeholder' => 'Seleccione un lineamiento',
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>