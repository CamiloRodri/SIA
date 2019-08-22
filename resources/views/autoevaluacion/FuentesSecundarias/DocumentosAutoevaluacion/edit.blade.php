{{-- Titulo de la pagina --}}
@section('title', 'Documentos Autoevaluación')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Modificar Documento autoevaluación')
        {!! Form::model($documento, [ 'route' => ['documental.documentos_autoevaluacion.update', $documento],
        'method' => 'PUT', 'id' => 'form_modificar_documento',
        'class' => 'form-horizontal form-label-left', 'novalidate' ])
        !!}
        @include('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion._form')
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">

                {{ link_to_route('documental.documentos_autoevaluacion.index',"Cancelar", [], 
                ['class' => 'btn btn-info']) }}
                {!! Form::submit('Modificar Documento',
                ['class' => 'btn btn-success']) !!}
            </div>
        </div>
        {!! Form::close() !!} @endcomponent
@endsection

{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
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
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Dropzone.js -->
    <script src="{{ asset('gentella/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

@endpush

{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        var comprobarDocumento = {{ isset($size)?'true':'false' }};
        Dropzone.options.myDropzone = {
            url: $('#form_modificar_documento').attr('action'),
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            acceptedFiles: 'application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*,.xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf',
            maxFiles: 1,
            maxFilesize: 10,
            addRemoveLinks: true,
            @if($documento->archivo)
            // The setting up of the dropzone
            init: function () {

                // Add server images
                var myDropzone = this;

                var file = {
                    name: '{{ $documento->archivo->ACV_Nombre .'.'. $documento->archivo->ACV_Extension}}',
                    size: "{{ $size }}"
                };
                myDropzone.options.addedfile.call(myDropzone, file);
                myDropzone.options.thumbnail.call(myDropzone, file, '{{ $documento->archivo->ruta }}');
                myDropzone.emit("complete", file);
                this.on("removedfile", function (file) {
                    comprobarDocumento = false;
                });

            }

            @endif

        };
        $(document).ready(function () {

            $('#factor').select2();
            $('#caracteristica').select2();
            $('#indicador').select2();
            $('#dependencia').select2();
            $('#tipo_documento').select2();

            selectDinamico("#factor", "#caracteristica", "{{url('admin/documental/documentos_autoevaluacion/caracteristicas')}}", ['#indicador']);
            selectDinamico("#caracteristica", "#indicador", "{{url('admin/documental/indicadores_documentales')}}");


            $('#indicador').prop('disabled', false);
            $('#caracteristica').prop('disabled', false);
            var form = $('#form_modificar_documento');
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
                        sessionStorage.setItem('update', 'El documento de autoevaluacion ha sido modificado exitosamente.');
                        window.location.replace(" {{ route('documental.documentos_autoevaluacion.index')}} ");
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
