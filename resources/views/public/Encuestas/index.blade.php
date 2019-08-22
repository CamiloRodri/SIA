@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Procesos para la autoevaluación @endsection
@section('titulo')Selección del grupo de interes @endsection
@section('content')
    @component('admin.components.panel')
        {!! Form::open([
        'route' => 'public.encuestas.store',
        'method' => 'POST',
        'id' => 'form_cargar_encuestas',
        'class' => 'form-horizontal form-label-lef',
        'novalidate'
        ])!!}
        @include('public.Encuestas.form')
        <br></br>
        <div class="col-md-6 col-md-offset-6">
            {!! Form::submit('Iniciar', ['class' => 'btn btn-success']) !!}
            <span style="display:inline-block; width: 10;"></span>
            {{ link_to_route('home',"Cancelar", [],
            ['class' => 'btn btn-danger']) }}
            <div>
                {!! Form::close() !!}
                </section>
            @endcomponent
            @endsection
            @push('styles')
                <!-- PNotify -->
                    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
                    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
                    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
                    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
                @endpush

                @push('scripts')}
                <!-- validator -->
                <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
                <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
                <!-- PNotify -->
                <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
                <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
                <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
                <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>

                @endpush
                @push('functions')
                    <script type="text/javascript">
                        $(document).ready(function () {
                            var form = $('#form_cargar_encuestas');
                            $('#grupos').select2();
                            $('#cargos').select2();
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
                            $('#grupos').change(function (e) {
                                e.preventDefault();
                                var valor = $("#grupos option:selected").text();
                                if (valor == "DIRECTIVOS ACADEMICOS")
                                    document.getElementById("container").classList.remove('hidden');
                                else
                                    document.getElementById("container").classList.add('hidden');
                            });
                            form.submit(function (e) {
                                e.preventDefault();
                                if ($("#grupos option:selected").text() == "DIRECTIVOS ACADEMICOS")
                                    window.location.href = "{{ url('encuesta') . '/'. request()->route()->parameter('slug_proceso') . '/' }}" + $("#grupos").val() + '/' + $("#cargos").val();
                                else
                                    window.location.href = "{{ url('encuesta') . '/'. request()->route()->parameter('slug_proceso') . '/' }}" + $("#grupos").val();

                            });
                        });
                    </script>
        @endpush