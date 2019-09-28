{{-- Titulo de la pagina --}}
@section('title', 'Consolidación de Factores')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Modificar Consolidación de Factor')

        <!-- Modal Cancelar-->
        <div class="modal fade" id="modal_mostrar_comprobar_modificar" tabindex="-1" role="dialog" aria-labelledby="modal_titulo">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_titulo">¿Esta seguro?</h4>
                    </div>
                    <div class="modal-body">
                        <h4>¿Esta seguro?, si es asi presione el botón aceptar.</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar </button>
                        <a class="btn btn-danger" href="#" id="aceptar_modificar" role="button">Aceptar</a>
                    </div>
                </div>
            </div>
        </div>
        <!--FIN Modal Cancelar-->
        {!! Form::model($consolidacion, [ 'route' => ['admin.consolidacion_factores.update', $consolidacion],
        'method' => 'PUT', 'id' => 'form_modificar_consolidacion_factor',
        'class' => 'form-horizontal form-label-lef', 'novalidate' ])
        !!}
        @include('autoevaluacion.SuperAdministrador.ConsolidacionFactores._form_edit')
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">

                {{ link_to_route('admin.consolidacion_factores.index',"Cancelar", [], ['class' => 'btn btn-info']) }}
                {!! Form::submit('Modificar Consolidacion de Factor',
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
            selectDinamico("#lineamiento", "#factor", "{{url('admin/factores')}}", ['#caracteristica']);
            selectDinamico("#factor", "#caracteristica", "{{url('admin/caracteristicas')}}");

            $('#factor').prop('disabled', false);
            $('#caracteristica').prop('disabled', false);
            var form = $('#form_modificar_consolidacion_factor');
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
                        Accept: 'application/json',
                        success: function (response, NULL, jqXHR) {
                            sessionStorage.setItem('update', 'La Consolidacion de Factores se ha modificado exitosamente.');
                            window.location.href = " {{ route('admin.consolidacion_factores.index')}} ";
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
