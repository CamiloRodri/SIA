<div class="item form-group">
    {!! Form::label('ITN_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Nombre', old('ITN_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,100}$',
        'data-parsley-pattern-message' => 'Por favor escriba un nombre válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Domicilio','Domicilio', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Domicilio', old('ITN_Domicilio'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,100}$',
        'data-parsley-pattern-message' => 'Por favor escriba un domicilio válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Caracter','Carácter de la Institución', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Caracter', old('ITN_Caracter'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,70}$',
        'data-parsley-pattern-message' => 'Por favor escriba un carácter de la institución válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_CodigoSNIES','Código SNIES', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_CodigoSNIES', old('ITN_CodigoSNIES'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un código SNIES válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Norma_Creacion','Norma de creación', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Norma_Creacion', old('ITN_Norma_Creacion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un norma de creación válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Estudiantes','Número de Estudiantes', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Estudiantes', old('ITN_Estudiantes'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[0, 60]",
        'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('metodologia','Metodología', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('FK_ITN_Metodologia', $metodologias, old('FK_ITN_Metodologia', isset($institucion)? $institucion->FK_ITN_Metodologia:''), [
            'placeholder' => 'Seleccione una Metodologia',
            'class' => 'select2_user form-control', 
            'required']) 
        !!}
</div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Profesor_Planta','Planta', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Profesor_Planta', old('ITN_Profesor_Planta'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba una planta válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Profesor_TCompleto','Tiempo completo ocasional', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Profesor_TCompleto', old('ITN_Profesor_TCompleto'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un valor para tiempo completo ocasional válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Profesor_TMedio','Medio tiempo', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Profesor_TMedio', old('ITN_Profesor_TMedio'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un valor para medio tiempo válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Profesor_Catedra','Catedra', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Profesor_Catedra', old('ITN_Profesor_Catedra'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un pofesor para catedra válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Graduados','N° de estudiantes graduados', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Graduados', old('ITN_Graduados'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un numero de estudiantes graduados válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Mision','Misión', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Mision', old('ITN_Mision'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba una misión válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Vision','Visión', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Vision', old('ITN_Vision'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba una visión válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('ITN_Descripcion', old('ITN_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba una descripción válida',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
        {!! Form::label('estado','Estado', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::select('FK_ITN_Estado', $estados, old('FK_ITN_Estado', isset($institucion)? $institucion->FK_ITN_Estado:''), [
                'placeholder' => 'Seleccione un estado',
                'class' => 'select2_user form-control', 
                'required']) 
            !!}
        </div>
</div>
<div class="item form-group">
    {!! Form::label('ITN_FuenteBoletinMes','Fuente Boletín estadístico, datos actualizados a: ', ['class'=>'control-label col-md-3 col-sm-3 col-xs-6'], ['placeholder'=>'Mes']) !!}
    <div class="col-md-3 col-sm-1 col-xs-1">
        {!! Form::text('ITN_FuenteBoletinMes', old('ITN_FuenteBoletinMes'),[ 'class' => 'form-control col-md-3 col-sm-3 col-xs-6', 'placeholder' => 'Mes',
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\., ]{1,25}$',
        'data-parsley-pattern-message' => 'Por favor escriba un mes válido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) 
        !!}
        {{-- {!! Form::select('ITN_FuenteBoletinMes', $meses, old('ITN_FuenteBoletinMes'), [
            'placeholder' => 'Seleccione un mes',
            'class' => 'select2_user form-control', 
            'required']) 
        !!} --}}
    </div>
<div class="item form-group">
    {!! Form::label('ITN_FuenteBoletinAnio','del ', [ 'class'=>'control-label col-md-1 col-sm-1 col-xs-6'], ['placeholder' => 'Año']) !!}
    <div class="col-md-1 col-sm-1 col-xs-1">
        {!! Form::text('ITN_FuenteBoletinAnio', old('ITN_FuenteBoletinAnio'),[ 'class' => 'form-control col-md-1 col-sm-1 col-xs-6', 'placeholder' => 'Año',
        'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[0, 4]",
        'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>

