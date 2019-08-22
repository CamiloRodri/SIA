{{-- Titulo de la pagina --}}
@section('title', 'Tipo respuestas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Crear Tipo de Respuesta')
        {!! Form::open([
            'route' => 'fuentesP.tipoRespuesta.store',
            'method' => 'POST',
            'id' => 'form_crear_tipoRespuestas',
            'class' => 'form-horizontal form-label-lef',
            'novalidate'
        ])!!}
        @include('autoevaluacion.FuentesPrimarias.TipoRespuestas.form')
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                {{ link_to_route('fuentesP.tipoRespuesta.index',"Cancelar", [], ['class' => 'btn btn-info']) }}
                {!! Form::submit('Crear Tipo de Respuestas', ['class' => 'btn btn-success']) !!}
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
            $('#estado').select2();
            document.getElementById('TotalPonderaciones').value = 10;
            $('#ponderacion').change(function (e) {
                e.preventDefault();
                var status = $('#ponderacion')[0].checked;
                if (status === true) {
                    var number = document.getElementById('cantidad').value;
                    if (number != 0 && number <= 5) {
                        var container = document.getElementById("container");
                        while (container.hasChildNodes()) {
                            container.removeChild(container.lastChild);
                        }
                        for (i = 1; i <= number; i++) {
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.appendChild(document.createTextNode("Ponderacion " + (i)));
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            container.innerHTML += '&nbsp;';
                            var input = document.createElement("input");
                            input.type = "text";
                            input.name = "Ponderacion_" + i;
                            input.maxLength = 3;
                            input.required = true;
                            input.size = 67;
                            input.pattern = "^[0-9.]*$";
                            input.style = "margin: 0px;width: 300px;height: 34px";
                            container.appendChild(input);
                            container.appendChild(document.createElement("br"));
                            container.appendChild(document.createElement("br"));
                        }
                    }
                    else {
                        $("#ponderacion").prop("checked", false);
                        new PNotify({
                                title: "Error",
                                text: "El valor para cantidad de respuestas no es valido",
                                type: 'error',
                                styling: 'bootstrap3'
                            }
                        )

                    }
                }
                else {
                    var container = document.getElementById("container");
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                }
            });
            var form = $('#form_crear_tipoRespuestas');
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
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response, NULL, jqXHR) {
                        $(form)[0].reset();
                        $(form).parsley().reset();
                        document.getElementById('TotalPonderaciones').value = 10;
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