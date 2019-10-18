{{-- Titulo de la pagina --}}
@section('title', 'Evidencia')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Modificar Evidencia')
        {!! Form::model($actividad, [
            'route' => ['admin.evidencia.update', $actividad],
            'method' => 'PUT',
            'id' => 'form_modificar_evidencia',
            'class' => 'form-horizontal form-label-lef',
            'novalidate'
        ])!!}
        @include('autoevaluacion.SuperAdministrador.Evidencias.form')
        <div class="form-group">
            {!! Form::label('archivo','Agregar Archivos', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
            <div class="col-md-6 col-sm-6 col-xs-12 dropzone" id="myDropzone">

            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                {{ link_to_route('admin.evidencia.index',"Cancelar", $actividad->FK_EVD_Actividad_Mejoramiento , ['class' => 'btn btn-info']) }}
                {!! Form::submit('Modificar Datos', ['class' => 'btn btn-success']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @endcomponent
@endsection

{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <!-- Dropzone.js -->
    <link href="{{ asset('gentella/vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
    <style>
        .dropzone {
            height: 40%;
            min-height: 0px !important;
        }
    </style>
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
    <!-- Dropzone.js -->
    <script src="{{ asset('gentella/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
@endpush


{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">

        var comprobarDocumento = {{ isset($size)?'true':'false' }};

        Dropzone.options.myDropzone = {
            url: $('#form_modificar_evidencia').attr('action'),
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            acceptedFiles: 'application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*,.xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf',
            maxFilesize: 10,
            addRemoveLinks: true,
            @if($actividad->archivo)
            // The setting up of the dropzone
            init: function () {


                // Add server images
                var myDropzone = this;

                var file = {
                    name: '{{ $actividad->archivo->ACV_Nombre}}',
                    size: "{{ $size }}"
                };
                myDropzone.options.addedfile.call(myDropzone, file);
                myDropzone.options.thumbnail.call(myDropzone, file, '{{ $actividad->archivo->ruta }}');
                myDropzone.emit("complete", file);
                this.on("removedfile", function (file) {
                    comprobarDocumento = false;
                });

            }

            @endif
        }
        $(document).ready(function () {
            var form = $('#form_modificar_evidencia');
            $(form).parsley({
                trigger: 'change',
                successClass: "has-success",
                errorClass: "has-error",
                classHandler: function (el) {
                    return el.$element.closest('.form-group');
                },
                errorsWrapper: '<p class="help-block help-block-error"></p>',
                errorTemplate: '<span></span>',
            });

            // Variable to store your files

            form.submit(function (e) {
                var formData = new FormData(this);
                formData.append('archivo', $('#myDropzone')[0].dropzone.getQueuedFiles()[0]);
                formData.append('comprobarArchivo', comprobarDocumento);
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response, NULL, jqXHR) {
                        sessionStorage.setItem('update', 'La evidencia ha sido modificada exitosamente.');
                        window.location.href = " {{ url('admin/evidencia/index')}} "  + "/" + '{{ $actividad->PK_ACM_Id }}';
                    },
                    error: function (data) {
                        console.log(data);
                        var errores = data.responseJSON.errors;
                        var msg = '';
                        $.each(errores, function (name, val) {
                            msg += val + '<br>';
                        });
                        new PNotify({
                            title: "Error!",
                            text: msg,
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                });
            });
        });

    </script>
@endpush