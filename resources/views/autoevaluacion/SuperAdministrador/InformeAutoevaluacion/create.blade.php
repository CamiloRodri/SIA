{{-- Titulo de la pagina --}}
@section('title', 'Informe Autoevaluación')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>
                Informe Autoevaluación
            </h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix">
            </div>
        </div>
        @if(session()->get('id_proceso'))
            @if(session()->get('estado_proceso'))

                <p>Aquí se genera el Informe Final de Autoevaluación, puede dejar los titulos por defecto o editar los titulos que iran en el encabezado.</p>
                <p>El siguiente cuadro es para subir la imagen (Logo de la Universidad), luego podrá generar y descargar el Informe.</p>
                @component('admin.components.panel')
                    <div class="panel-body">
                        {!! Form::open(['route'=> 'admin.informes_autoevaluacion.store', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
                        <div class="dz-message" style="height:200px;">
                            Suelta tu imagen aquí
                        </div>
                        <div class="dropzone-previews"></div>
                        <button type="submit" class="btn btn-success" id="submit">Guardar imagen</button>
                        {!! Form::close() !!}
                    </div>



                    </div>
                    <div class="x_panel">

                        {!! Form::open([
                            'route' => 'admin.informes_autoevaluacion.store',
                            'method' => 'POST',
                            'id' => 'form_crear_institucion',
                            'class' => 'form-horizontal form-label-lef',
                            'novalidate'
                        ])!!}
                        @include('autoevaluacion.SuperAdministrador.InformeAutoevaluacion._form')
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Form::submit('Generar y Descargar',
                                    [   'class' => 'btn btn-success', 'data-toggle' => 'tooltip',
                                        'data-placement'=>'right', 'title'=>'Esta acción puede tardar más tiempo de lo esperado'
                                    ])
                                !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endcomponent
            @else
                Este proceso aun no se ha cerrado.
            @endif
        @else
            Por favor seleccione un proceso
        @endif

@endsection

{{-- Scripts necesarios para el formulario --}}
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    {{-- Dropzone --}}
    {{-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('gentella/vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">


@endpush

{{-- Scripts necesarios para el formulario --}}
@push('scripts')
    <!-- validator -->
    <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

    <script src="{{ asset('gentella/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
    {{-- Dropzone --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

@endpush
{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: true,
            maxFilezise: 2,
            maxFiles: 1,
            acceptedFiles: '.png, .jpeg,.jpg',

            init: function() {
                var submitBtn = document.querySelector("#submit");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("addedfile", function(file) {
                    alert("Por favor, guarde la imagen");
                    // $(function () {
                    //     new PNotify({
                    //         title: "Imagen Cargada",
                    //         text: 'Por favor, guarde la imagen',
                    //         type: 'info',
                    //         styling: 'bootstrap3'
                    //     });
                    // });
                });

                this.on("complete", function(file) {
                    myDropzone.removeFile(file);
                });

                this.on("success", function(file){
                    myDropzone.processQueue.bind(myDropzone);
                    alert("Ya puede generar y descargar el Informe");
                    // $(function () {
                    //     new PNotify({
                    //         title: "Imagen Guardada",
                    //         text: 'Ya puede generar un Informe con su propio logo',
                    //         type: 'success',
                    //         styling: 'bootstrap3'
                    //     });
                    // });
                });
            }
        };

        @if (session('division_zero'))
            new PNotify({
                title: 'Información Incompleta',
                text: 'No se ha realizado la solución de la encuesta.',
                type: 'error',
                styling: 'bootstrap3',
                sound: true
	        });
        @endif
        @if (session('error'))
            new PNotify({
                tittle:'Información Incompleta',
                text:'Por favor, completar la información requerida, Institución, Programa, además de completar el proceso de Plan de Mejoramiento.',
                type:'error',
                styling:'bootstrap3',
                sound: true
	        });
        @endif
        
    </script>

@endpush
