{{-- Titulo de la pagina --}}
@section('title', 'Modificar Pregunta de Encuesta')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Modificar Pregunta')
        {!! Form::model($preguntas, [
            'route' => ['fuentesP.establecerPreguntas.update', $preguntas],
            'method' => 'PUT',
            'id' => 'form_modificar_pregunta_encuesta',
            'class' => 'form-horizontal form-label-lef',
            'novalidate'
        ])!!}
        @include('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.form')
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">

                {{ link_to_route('fuentesP.establecerPreguntas.datos',"Cancelar", [Session::get('id_encuesta')], ['class' => 'btn btn-info'])  }}
                {!! Form::submit('Modificar Pregunta', ['class' => 'btn btn-success']) !!}
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
    <!-- Select2 -->
    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
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
@endpush
{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#lineamiento').select2();
            $('#factor').select2();
            $('#caracteristica').select2();
            $('#preguntas').select2();
            $('#grupoInteres').select2();
            selectDinamico("#lineamiento", "#factor", "{{url('admin/factores')}}", ['#caracteristica,#preguntas']);
            selectDinamico("#factor", "#caracteristica", "{{url('admin/caracteristicas')}}");
            selectDinamico("#caracteristica", "#preguntas", "{{url('admin/fuentesPrimarias/preguntas')}}");
            var form = $('#form_modificar_pregunta_encuesta');
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
            $('#factor').prop('disabled', false);
            $('#caracteristica').prop('disabled', false);
            $('#preguntas').prop('disabled', false);
            $('#grupoInteres').prop('disabled', true);
            form.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function (response, NULL, jqXHR) {
                        sessionStorage.setItem('update', 'La pregunta ha sido modificada exitosamente.');
                        window.location.href = " {{ route('fuentesP.establecerPreguntas.datos',Session::get('id_encuesta'))}} ";
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