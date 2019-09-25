{{-- Titulo de la pagina --}}
@section('title', 'Evaluar Documentos Autoevaluación')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Evaluar Documento autoevaluación')
        <div>
            Puntuación para Calificar: 
            <img src="{{ asset('titan\assets\images\calificacion.png') }}" class="img-responsive" alt=""> </div>
        </div>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Evaluar</div>
                
                <table class="table table-bordered">
                    <tr>
                        <th>Factor:</th>
                        <td>{{ $documento[0]->indicadorDocumental->caracteristica->factor->FCT_Nombre }}</td>
                    </tr>
                    <tr>
                        <th>Característica:</th>
                        <td>{{ $documento[0]->indicadorDocumental->caracteristica->CRT_Nombre }}</td>
                    </tr>
                    <tr>
                        <th>Indicador:</th>
                        <td>{{ $documento[0]->indicadorDocumental->IDO_Nombre }}</td>
                    </tr>
                    <tr>
                        <th>Dependencia:</th>
                        <td>{{ $documento[0]->dependencia->DPC_Nombre }}</td>
                    </tr>
                    <tr>
                        <th>Tipo de documento:</th>
                        <td>{{ $documento[0]->tipoDocumento->TDO_Nombre }}</td>
                    </tr>
                    <tr>
                        <th>Nombre Documento:</th>
                        <td>{{$documento[0]->archivo->ACV_Nombre ?? 'Link'}}</td>
                    </tr>
                    <tr>
                        <th>Numero:</th>
                        <td>{{$documento[0]->DOA_Numero ?? 'Sin numero'}}</td>
                    </tr>
                    <tr>
                        <th>Año:</th>
                        <td>{{$documento[0]->DOA_Anio ?? 'Año no especificado'}}</td>
                    </tr>
                    <tr>
                        <th>Documento:</th>
                        <td><a class="btn btn-success btn-xs" 
                        href="{{$documento[0]->DOA_Link != null?
                        $documento[0]->DOA_Link:route('descargar') . '?archivo=' . $documento[0]->archivo->ruta}}" 
                            target="_blank" role="button">Descargar</a></td>
                    </tr>
                    <tr>
                        <th>Descripción general:</th>
                        <td>{{ $documento[0]->DOA_DescripcionGeneral ?? 'Ninguna descripción general guardada' }}</td>
                    </tr>
                    <tr>
                        <th>Contenido especifico:</th>
                        <td>{{ $documento[0]->DOA_ContenidoEspecifico ?? 'Ningún contenido especifico guardado' }}</td>
                    </tr>
                    <tr>
                        <th>Contenido adicional:</th>
                        <td>{{ $documento[0]->DOA_ContenidoEspecifico ?? 'Ningún contenido adicional guardado' }}</td>
                    </tr>
                    <tr>
                        <th>Observación Documento:</th>
                        <td>{{ $documento[0]->DOA_Observacion ?? 'Ningún contenido adicional guardado' }}</td>
                    </tr>
                    <form action="{{ route('documental.documentos_autoevaluacion.evaluar.post', request()->route()->parameter('id_documento')) }}" method="post" id="evaluar_documento">
                    @csrf
                    <tr>
                        <th>Calificación:</th>
                        <td>  
                            <div class="row">
                                    <div class="item form-group">
                                        {!! Form::label('DOA_Calificacion','Calificación de 1.0 a 5.0', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {!! Form::text('DOA_Calificacion', old('DOA_Calificacion',  $documento[0]->DOA_Calificacion ?? ''),
                                            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
                                            'required'=> 'required', 
                                            'data-parsley-pattern' => '^[0-9.]+$',
                                            'data-parsley-pattern-message' => 'Error en el texto',
                                            'data-parsley-length' => "[3, 50]",
                                            'data-parsley-trigger'=>"change" ] ) !!}
                                        </div>
                                    </div>
                                </div>                        
                        </td>
                    </tr>
                    <tr>
                        <th>Observación Calificación:</th>
                        <td>       
                            <div class="row">
                                    <div class="form-group">
                                        {!! Form::label('DOA_Observaciones_Calificacion','Observaciones', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {!! Form::textarea('DOA_Observaciones_Calificacion', old('DOA_Observaciones_Calificacion', $documento[0]->DOA_Observaciones_Calificacion ?? ''), 
                                            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
                                            "style"=>"height: 88px;" ] ) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn-xs btn-info pull-right" type="submit">Guardar</button>
                                </div>
                        
                        </td>
                    </tr>
                    </form>
                </table>
        </div>
        
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

    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            var form = $('#evaluar_documento');
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
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response, NULL, jqXHR) {
                        sessionStorage.setItem('update', 'El documento de autoevaluacion se ha calificado exitosamente.');
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
