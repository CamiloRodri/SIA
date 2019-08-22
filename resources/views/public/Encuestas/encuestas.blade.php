@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Proceso de Autoevaluación @endsection
@section('titulo')Encuesta @endsection
@section('content')
    @component('admin.components.panel')
        {!! Form::open([
        'route' => 'public.encuestas.store',
        'method' => 'POST',
        'id' => 'form_encuestas',
        'class' => 'form-horizontal form-label-lef',
        'novalidate'
        ])!!}
        @include('public.Encuestas.wizard')
        <br>
        {!! Form::close() !!}
        </div>
        </div>
        </div>
        </section>
    @endcomponent
@endsection

@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/SmartWizard/dist/css/smart_wizard.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('gentella/vendors/SmartWizard/dist/css/smart_wizard_theme_dots.css') }}" rel="stylesheet"
          type="text/css"/>

@endpush

@push('scripts')
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <script src="{{ asset('gentella/vendors/SmartWizard/dist/js/jquery.smartWizard.min.js') }}"></script>
@endpush

@push('functions')
    <script type="text/javascript">
        var form = $('#form_encuestas');
        $(document).ready(function () {
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
        window.location.hash = '';
        $(document).ready(function () {
            $('#smartwizard').smartWizard({
                selected: 0,
                showStepURLhash: false,
                lang: {
                    next: 'Siguiente',
                    previous: 'Anterior',
                },
                toolbarSettings: {
                    showNextButton: true,
                    showPreviousButton: false,
                }, 
            });
            var contador = 0;
            $('.sw-btn-next').bind('click', function () {
                if(contador >= {{count($preguntas)}}){
                    $('.sw-btn-next').prop("disabled", false);}
                else{
                    $('.sw-btn-next').prop("disabled", true);
                    $('#finalizar').prop("disabled", true);}
                contador++;
                window.scrollTo(0, 350);
            });
            $(".radios").change(function () {
                $('.sw-btn-next').prop("disabled", false);
                $('#finalizar').prop("disabled", false);
            });
            $(document).ajaxStart(function () {
                $('#finalizar').prop("disabled", true);
                }).ajaxStop(function () {
                $('#finalizar').prop("disabled", false);
            });
            form.submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('proceso', '{{ request()->route()->parameter('slug_proceso') }}');
                formData.append('grupo', '{{ request()->route()->parameter('grupo') }}');
                formData.append('cargo', '{{ request()->route()->parameter('cargo') }}');
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response, NULL, jqXHR) {
                        new PNotify({
                            title: response.title,
                            text: response.msg,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        window.location.href = " {{route('home')}} ";
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
                        window.location.href = " {{route('home')}} ";
                    }
                });
            });
        });
    </script>
@endpush