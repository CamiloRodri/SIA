{{-- Titulo de la pagina --}}
@section('title', 'Importar')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Importar Preguntas')
        {!! Form::open([
            'route' => 'fuentesP.Importarpreguntas.store',
            'method' => 'POST',
            'files' => true,
            'id' => 'form_importar_preguntas',
            'class' => 'form-horizontal form-label-left'

        ])!!}
        <div class="form-group">
            {!! Form::label('archivo','Importar preguntas desde excel', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
            <div class="col-md-6 col-sm-6 col-xs-12 dropzone" id="myDropzone">
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                {{ link_to_route('fuentesP.preguntas.index',"Cancelar", [], ['class' => 'btn btn-info']) }}
                {!! Form::submit('Importar Preguntas', ['class' => 'btn btn-success', 'id'=>'importarPreguntas']) !!}
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
        Dropzone.options.myDropzone = {
            url: $('#form_importar_preguntas').attr('action'),
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: 4,
            acceptedFiles: '.xlsx',
            addRemoveLinks: true,
        }
        $(document).ready(function () {
            var form = $('#form_importar_preguntas');
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

            form.submit(function (e) {

                console.log($('#myDropzone')[0].dropzone.getAcceptedFiles()[0]);
                var formData = new FormData(this);
                formData.append('archivo', $('#myDropzone')[0].dropzone.getAcceptedFiles()[0]);
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response, NULL, jqXHR) {
                        $('#myDropzone')[0].dropzone.removeAllFiles();
                        $(form)[0].reset();
                        $(form).parsley().reset();
                        new PNotify({
                            title: response.title,
                            text: response.msg,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    },
                    error: function (data) {

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