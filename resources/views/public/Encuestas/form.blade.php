<div class="form-group">
    {!! Form::label('PK_GIT_Id', 'Grupo de Interes', ['class' => 'control-label col-md-5 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-8 col-xs-12">
        {!! Form::select('PK_GIT_Id', $grupos,old('PK_GIT_Id'),
        ['class' => 'select2 form-control', 
        'required' => 'required',
        'placeholder' => 'Seleccione una grupo de interes',  
        'id' => 'grupos']) !!}
    </div>
</div>

<div id="container" class="hidden">
    {!! Form::label('PK_CAA_Id', 'Cargo Administrativo', ['class' => 'control-label col-md-5 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-8 col-xs-12">
        {!! Form::select('PK_CAA_Id', $cargos,old('PK_CAA_Id'),
        [
        'class' => 'select2 form-control',
        'id' => 'cargos',
        'style' => 'width:360px;']) !!}
    </div>
</div>