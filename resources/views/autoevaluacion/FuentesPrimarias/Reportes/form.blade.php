<div class="form-group">
    {!! Form::label('PK_GIT_Id', 'Grupo de Interes', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_GIT_Id', $grupos, old('PK_GIT_Id', isset($grupos)? $grupos: ''), ['class' => 'select2 form-control',
         'id' => 'grupos',
        'style' => 'width:100%',
        'placeholder' => 'Seleccione un grupo de interes', 
        'required' => 'required', 
        ])
        !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('PK_PGT_Id', 'Pregunta', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_PGT_Id', isset($preguntasEncuesta)?$preguntasEncuesta:[],
         old('PK_PGT_Id', isset($preguntasEncuesta)? $preguntasEncuesta
        : ''), ['class' => 'select2 form-control','placeholder' => 'Seleccione una pregunta', 
        'required' => '',
        'id' => 'preguntas']) !!}
    </div>
</div>