{!! Form::hidden('PK_RPS_Id', old('PK_RPS_Id'), ['id' => 'PK_RPS_Id']) !!}

<div class="form-group">
    {!! Form::label('id', 'Responsables', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('id', $usuarios, old('id', isset($responsables)? $responsables->FK_RPS_Responsable: ''), ['class' => 'select2 form-control',
         'id' => 'responsable',
        'style' => 'width:100%',
        'placeholder' => 'Seleccione un responsable', 
        'required' => 'required', 
        ])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_CAA_Id', 'Cargo', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_CAA_Id', $cargos, old('PK_CAA_Id', isset($responsables)? $responsables->FK_RPS_Cargo: ''), ['class' => 'select2 form-control',
         'id' => 'cargo',
        'style' => 'width:100%',
        'placeholder' => 'Seleccione un cargo', 
        'required' => 'required', 
        ])
        !!}
    </div>
</div>