<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factores)?$factores:[], old('PK_FCT_Id', isset($documento)? $documento->indicadorDocumental->caracteristica->FK_CRT_Factor: ''), 
        ['class' => 'select2 form-control', 'placeholder' => 'Seleccione un factor', 'required' => '',
        'id' => 'factor']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[], old('PK_CRT_Id', 
        isset($documento)? $documento->indicadorDocumental->FK_IDO_Caracteristica:
        ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 'required' => '', 'id'
        => 'caracteristica']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_IDO_Id', 'Indicador Documental', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_IDO_Id', isset($indicadores)?$indicadores:[],
        old('PK_IDO_Id', isset($documento)? $documento->FK_DOA_IndicadorDocumental:''),
        ['class' => 'select2 form-control','placeholder' => 'Seleccione un indicador', 'required' => '',
        'id' => 'indicador']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_DPC_Id', 'Dependencia que expide el documento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_DPC_Id', $dependencias,
        old('PK_DPC_Id', isset($documento)? $documento->FK_DOA_Dependencia:''),
        ['class' => 'select2 form-control','placeholder' => 'Seleccione una dependencia', 'required' => '',
        'id' => 'dependencia']) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('PK_TDO_Id', 'Tipo de documento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_TDO_Id', $tipoDocumentos,
        old('PK_DPC_Id', isset($documento)? $documento->FK_DOA_TipoDocumento:''),
        ['class' => 'select2 form-control','placeholder' => 'Seleccione un tipo de documento', 'required' => '',
        'id' => 'tipo_documento']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_Numero','Numero', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-2 col-sm-3 col-xs-12">
        {!! Form::text('DOA_Numero', old('DOA_Numero'),[ 'class' => 'form-control', 'required'
        => 'required', 'data-parsley-type'=>"number" , 
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
    {!! Form::label('DOA_Anio','Año', ['class'=>'control-label col-md-1 col-sm-1 col-xs-12']) !!}
    <div class="col-md-3 col-sm-2 col-xs-12">
        {!! Form::text('DOA_Anio', old('DOA_Anio'),[ 'class' => 'form-control',
        'data-parsley-type'=>"number" , 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_Link','Link', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DOA_Link', old('DOA_Link'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'data-parsley-pattern' => 'https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)',
        'data-parsley-pattern-message' => 'Por favor ingrese un link valido', 
        'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('archivo','Archivo', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12 dropzone" id="myDropzone">
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_DescripcionGeneral','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('DOA_DescripcionGeneral', old('DOA_DescripcionGeneral'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'data-parsley-trigger'=>"change",
        "style"=>"height: 88px;" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_ContenidoEspecifico','Contenido especifico que responde al indicador', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('DOA_ContenidoEspecifico', old('DOA_ContenidoEspecifico'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        "style"=>"height: 88px;" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_ContenidoAdicional','Contenido adicional que responde al indicador', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('DOA_ContenidoAdicional', old('DOA_ContenidoEspecifico'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        "style"=>"height: 88px;" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('DOA_Observaciones','Observaciones', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('DOA_Observaciones', old('DOA_Observaciones'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        "style"=>"height: 88px;" ] ) !!}
    </div>
</div>