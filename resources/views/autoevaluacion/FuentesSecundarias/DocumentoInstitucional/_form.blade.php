<div class="item form-group">
    {!! Form::label('DOI_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DOI_Nombre', old('CRT_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error, digite un nombre valido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('DOI_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DOI_Descripcion', old('CRT_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 500]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('link','Link', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('link', old('link'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
            'data-parsley-length' => "[1, 500]",
            'id' =>'id_link',
            'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('documento','Grupo de Documentos', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select id= "grupoDocumentos" class="select2_user form-control" name="grupoDocumentos" >
            @foreach($grupoDocumentos as $grupodocumento)
        <option selected="{{ isset($user)?  }}" value="{{ $grupodocumento->PK_GRD_Id }}">{{ $grupodocumento->GRD_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_DOI_GrupoDocumento',$grupoDocumentos, old('FK_DOI_GrupoDocumento'), [
            'placeholder' => 'Seleccione un Grupo de Documentos',
            'class' => 'select2_user form-control',
            'id' => 'grupoDocumentos'
            ]) !!}
    </div>
</div>


