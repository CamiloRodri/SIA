<div class="form-group col-sm">
    {!! Form::label('PK_SDS_Id', 'Instituciones', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ITNob_Id', $instituciones, $idInstitucion, [ 'placeholder' => 'Seleccione una institución',
            'class' => 'select2 form-control', 'required' => '', 'id' => 'institucion'])
        !!}
    </div>
</div>
<div class="form-group col-sm">
    {!! Form::label('PK_SDS_Id', 'Sede', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_SDS_Id', $sedes, old('PK_SDS_Id',
            isset($programaAcademico)? $programaAcademico->FK_PAC_Sede: ''), [ 'placeholder' => 'Seleccione una sede',
            'class' => 'select2 form-control', 'required' => '', 'id' => 'sede'])
        !!}
    </div>
</div>
<div class="form-group col-sm">
    {!! Form::label('PK_FCD_Id', 'Facultad', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_FCD_Id', $facultades,
            old('PK_FCD_Id', isset($programaAcademico)? $programaAcademico->FK_PAC_Facultad: ''),
            ['class' => 'select2 form-control','placeholder' => 'Seleccione una facultad', 'required'
            => '', 'id' => 'facultad'])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PK_ESD_Id', 'Estado', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_ESD_Id', $estados,
            old('PK_ESD_Id', isset($programaAcademico)? $programaAcademico->FK_PAC_Estado: ''),
            ['class' => 'select2 form-control','placeholder' => 'Seleccione un estado', 'required'
            => '', 'id' => 'estado'])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Nombre', old('PAC_Nombre'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Nivel_Formacion','Nivel de Formación', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Nivel_Formacion', old('PAC_Nivel_Formacion'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Titutlo_Otorga','Titulo que otorga', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Titutlo_Otorga', old('PAC_Titutlo_Otorga'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Situacion_Programa','Situación actual del programa', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Situacion_Programa', old('PAC_Situacion_Programa'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Anio_Inicio_Actividades','Fecha de iniciación de actividades', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Anio_Inicio_Actividades', old('PAC_Anio_Inicio_Actividades'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'Digitar mes y año. (Enero de 2000)',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PAC_Descripcion','Descripción', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::textarea('PAC_Descripcion', old('PAC_Descripcion'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'rows' => '5',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,200]',
            'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PAC_Anio_Inicio_Programa','Año de iniciacion de programa', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Anio_Inicio_Programa', old('PAC_Anio_Inicio_Programa'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[3,4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Lugar_Funcionamiento','Lugar de funcionamiento', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Lugar_Funcionamiento', old('PAC_Lugar_Funcionamiento'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[3,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Norma_Interna','Norma interna de creación', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Norma_Interna', old('PAC_Norma_Interna'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'el acuerdo xx del xx de xx del año xx',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Resolucion_Registro','Resolución de registro calificado', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Resolucion_Registro', old('PAC_Resolucion_Registro'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'Resolución del MEN',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Codigo_SNIES','Código SNIES', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Codigo_SNIES', old('PAC_Codigo_SNIES'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
            'data-parsley-pattern-message' => 'Error en el texto',
            'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] )
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PK_MTD_Id', 'Metodología', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::select('PK_MTD_Id', $metodologias,
            old('PK_MTD_Id', isset($programaAcademico)? $programaAcademico->FK_PAC_Metodologia: ''),
            ['class' => 'select2 form-control','placeholder' => 'Seleccione una metodología', 'required'
            => '', 'id' => 'estado'])
        !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('PAC_Numero_Creditos','Número de creditos', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Numero_Creditos', old('PAC_Numero_Creditos'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Duracion','Duración', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Duracion', old('PAC_Duracion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'Digitar cantidad (Nueve (9) semestres académicos)',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Jornada','Jornada', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Jornada', old('PAC_Jornada'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Duracion_Semestre','Duración de c/semestre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Duracion_Semestre', old('PAC_Duracion_Semestre'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'Digitar cantidad (Diez y seis (16) semanas)',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Periodicidad','Periodicidad de la admisión', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Periodicidad', old('PAC_Periodicidad'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,20]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Adscrito','Adscrito', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Adscrito', old('PAC_Adscrito'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,50]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Area_Conocimiento','Área del conocimiento', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Area_Conocimiento', old('PAC_Area_Conocimiento'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,100]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Nucleo','Nucleo básico del conocimiento', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Nucleo', old('PAC_Nucleo'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,100]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Area_Formacion','Área de formación', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('PAC_Area_Formacion', old('PAC_Area_Formacion'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z0-9-_\.,;:()ñÑáéíóúÁÉÍÓÚ ]+$',
        'data-parsley-pattern-message' => 'Error en el texto',
        'data-parsley-length'=>'[5,100]', 'data-parsley-trigger'=>"change" ] ) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Estudiantes','Número actual de estudiantes', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Estudiantes', old('PAC_Estudiantes'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[2, 10]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Egresados','Número de egresados', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Egresados', old('PAC_Egresados'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[2, 10]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Valor_Matricula','Valor de la matricula', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Valor_Matricula', old('PAC_Valor_Matricula'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required', 'placeholder' => 'Número de SMLV',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 2]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Docentes_Actual','Docentes Actuales', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Docentes_Actual', old('PAC_Docentes_Actual'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Directivos_Academicos','Directivos', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Directivos_Academicos', old('PAC_Directivos_Academicos'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Administrativos','Administrativos', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Administrativos', old('PAC_Administrativos'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Egresados_Cinco','Egresados (últimos 5 años)', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Egresados_Cinco', old('PAC_Egresados_Cinco'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('PAC_Empresarios','Instituciones o Sector Productivo/Empresarios', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::number('PAC_Empresarios', old('PAC_Empresarios'),
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
            'required' => 'required',
            'data-parsley-type'=>"number",
            'data-parsley-length' => "[1, 4]",
            'data-parsley-trigger'=>"change"])
        !!}
    </div>
</div>
