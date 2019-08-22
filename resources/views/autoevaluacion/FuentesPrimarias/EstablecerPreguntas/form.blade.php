<div class="item form-group">
    {!! Form::label('PK_LNM_Id', 'Lineamiento', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_LNM_Id', $lineamientos, old('PK_LNM_Id', isset($preguntas)? 
        $preguntas->preguntas->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id', 'LNM_Nombre'): ''), [
            'placeholder' => 'Seleccione un lineamiento',
            'class' => 'select2 form-control',
            'id' => 'lineamiento']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_FCT_Id', 'Factor', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCT_Id', isset($factores)?$factores:[], old('PK_FCT_Id', isset($preguntas)? 
        $preguntas->preguntas->caracteristica->factor()->pluck('PK_FCT_Id', 'FCT_Nombre'): ''), ['class' => 'select2 form-control',
        'placeholder' => 'Seleccione un factor',
        'id' => 'factor']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_CRT_Id', 'Caracteristica', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CRT_Id', isset($caracteristicas)?$caracteristicas:[],
         old('PK_CRT_Id', isset($preguntas)? $preguntas->preguntas->FK_PGT_Caracteristica
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una característica', 
        'required' => '',
        'id' => 'caracteristica']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_PGT_Id', 'Pregunta', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_PGT_Id', isset($preguntasEncuesta)?$preguntasEncuesta:[],
         old('PK_PGT_Id', isset($preguntas)? $preguntas->preguntas->PK_PGT_Id
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una pregunta', 
        'required' => '',
        'id' => 'preguntas']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('grupos','Grupos de Interes',['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('gruposInteres[]', $grupos, 
        old('grupos', isset($grupos,$preguntas)? 
        $preguntas->grupos()->pluck('PK_GIT_Id') : ''),
        ['class'=> 'select2_grupos form-control', 'multiple' => 'multiple', 'required' => '',
        'id' => 'grupoInteres']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::hidden('PK_BEC_Id', Session::get('id_encuesta')) !!}
</div>