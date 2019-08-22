<div class="item form-group">
    {!! Form::label('CRT_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Nombre', old('CRT_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,50}$',
        'data-parsley-pattern-message' => 'Error, digite un nombre valido',
        'data-parsley-length' => "[1, 50]",
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('CRT_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Descripcion', old('CRT_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,500}$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 500]",
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('CRT_Identificador','Identificador', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Identificador', old('CRT_Identificador'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[1, 10]",
        'data-parsley-trigger'=>"change" ])
        !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('FK_FCT_Lineamiento','Lineamiento', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        <script>var ruta = "{{url('admin/caracteristicas/factor/')}}";
            var id_one = "#lineamiento";
            var id_two = "#factores";</script>
        {!! Form::select('FK_FCT_Lineamiento',$lineamientos, old('FK_FCT_Lineamiento', isset($caracteristica)?$caracteristica->factor->lineamiento()->pluck('PK_LNM_Id', 'LNM_Nombre') : ''), [
            'placeholder' => 'Seleccione un lineamiento',
            'class' => 'select2_user form-control',
            'id' => 'lineamiento',
            'required']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('FK_CRT_Factor','Factor', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('FK_CRT_Factor', isset($factores)? $factores : [] , old('FK_CRT_Factor', isset($caracteristica)? $caracteristica->factor->PK_FCT_Id:''), [
            'placeholder' => 'Seleccione un Factor',
            'class' => 'select2_user form-control',
            'id' => 'factores',
            'required']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('estado','Estado', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('FK_CRT_Estado',$estados, old('FK_CRT_Estado'), [
            'placeholder' => 'Seleccione un estado',
            'class' => 'select2_user form-control',
            'id' => 'estado',
            'required']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ambito','Ambito de Responsabilidad', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('FK_CRT_Ambito',$ambitos, old('FK_CRT_Ambito'), [
            'placeholder' => 'Seleccione un Ambito de Responsabilidad',
            'class' => 'select2_user form-control',
            'id' => 'ambito'
            ]) !!}
    </div>
</div>


