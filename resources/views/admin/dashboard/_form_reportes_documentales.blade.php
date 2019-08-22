<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="item form-group">
        {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-8 col-sm-8 col-xs-12">
            {!! Form::select('PK_FCT_Id', isset($factoresDocumentales)?$factoresDocumentales:[], old('PK_FCT_Id', isset($documento)? $documento->indicadorDocumental->caracteristica->FK_CRT_Factor:
            ''), ['class' => 'select2 form-control', 'placeholder' => 'Seleccione un factor', 'required' => '', 'id' => 'factor_documental'])
            !!}
        </div>
    </div>
    <div class="item form-group">
        {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-8 col-sm-8 col-xs-12">
            {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[], old('PK_CRT_Id', isset($documento)? $documento->indicadorDocumental->FK_IDO_Caracteristica:
            ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 'required' => '', 'id'
            => 'caracteristica']) !!}
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="item form-group">
        {!! Form::label('PK_DPC_Id', 'Dependencia', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-8 col-sm-8 col-xs-12">
            {!! Form::select('PK_DPC_Id', $dependencias, old('PK_DPC_Id', isset($documento)? $documento->FK_DOA_Dependencia:''), ['class'
            => 'select2 form-control','placeholder' => 'Seleccione una dependencia', 'required' => '', 'id' => 'dependencia'])
            !!}
        </div>
    </div>
    <div class="item form-group">
        {!! Form::label('PK_TDO_Id', 'Tipo de documento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-8 col-sm-8 col-xs-12">
            {!! Form::select('PK_TDO_Id', $tipoDocumentos, old('PK_DPC_Id', isset($documento)? $documento->FK_DOA_TipoDocumento:''),
            ['class' => 'select2 form-control','placeholder' => 'Seleccione un tipo de documento', 'required' => '', 'id'
            => 'tipo_documento']) !!}
        </div>
    </div>
</div>