<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factoresEncuestas)?$factoresEncuestas:[], old('PK_FCT_Id', isset($factoresEncuestas)?$factoresEncuestas:[])
        , ['class' => 'select2 form-control', 'placeholder' => 'Seleccione un factor', 'required' => '', 'id' => 'factor'])
        !!}
    </div>
</div>