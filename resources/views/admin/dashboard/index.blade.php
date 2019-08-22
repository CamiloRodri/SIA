{{-- Titulo de la pagina --}}
@section('title', 'Home')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Bienvenido a la plataforma SIA.')

        @can('SUPERADMINISTRADOR')

            @if(session()->get('id_proceso') && isset($factoresDocumentales))
                @if($factoresDocumentales->isNotEmpty())

                    <div id="graficas" class="hidden">
                        <h3>Reporte Documental</h3>
                        <hr>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                         aria-valuemin="0" aria-valuemax="100"
                                         style="width:40%;color:black">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <canvas id="pie_completado" height="220"></canvas>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <canvas id="fechas_cantidad" height="220"></canvas>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            {!! Form::open([
                                    'route' => 'documental.informe_documental.filtrar',
                                    'method' => 'POST',
                                    'id' => 'form_filtros_documental',
                                    'class' => 'form-horizontal form-label-left',
                                    'novalidate'
                            ])!!}
                            <div class="col-xs-12">
                                @include('admin.dashboard._form_reportes_documentales')

                                <div class="col-xs-12">
                                    <hr/>
                                </div>
                                <canvas id="documentos_indicador" height="150"></canvas>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <hr>
                        <h3>Reporte Encuestas</h3>
                        <hr>

                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <canvas id="pie_filtro" height="100"></canvas>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            {!! Form::open([
                                    'route' => 'primarias.informe_encuestas.filtrar',
                                    'method' => 'POST',
                                    'id' => 'form_filtros_encuestas',
                                    'class' => 'form-horizontal form-label-left',
                                    'novalidate'
                            ])!!}
                            <div class="col-xs-12">
                                @include('admin.dashboard._form_reportes encuestas1')

                                <div class="col-xs-12">
                                    <hr/>
                                </div>
                                <canvas id="encuestados" height="150"></canvas>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    <hr/>
                                </div>
                                </br>
                                <canvas id="caracteristicas" height="70"></canvas>
                                </br></br>
                                @include('admin.dashboard._form_reportes_encuestas2')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="row text-right">
                        <form target="_blank" id="form_generar_pdf"
                              action="{{ route('admin.informe_general.descargar') }}" method="post">
                            @csrf
                            <input type="hidden" name="json_datos" id="hidden_html"/>
                            <button class="btn btn-danger" id="generar_reporte"><i class="fa fa-file-pdf-o"></i> Generar
                                Reporte
                            </button>
                        </form>
                    </div>

                    </div>
                @else
                    El proceso aun no tiene datos para mostrar.
                @endif
            @else
                Por favor seleccione un proceso
            @endif

        @endcan
        <!-- Modal-->
        <div class="modal fade" id="modal_ambito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_titulo">Por favor cambiar su contraseña</h4>
                    </div>
                    <div class="modal-body" >
                            <form  name="f1" >
                                    <div class="form-group row">
                                            <label for="example-password-input" id="clave1" class="col-2 col-form-label control-label">Por motivos de seguridad por favor cambiar la contrasela dando clic en el siguiente boton </label>

                                    </div>
                                    <div>
                                            <a  href="{{route('reset.index')}}"  class="btn btn-danger">CAMBIAR</a>
                                    </div>

                       </div>

                </div>
            </div>
        </div>
        <!--FIN Modal CREAR-->
    @endcomponent
@endsection

@push('scripts')
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
<!-- Select2 -->
    @endpush
@push('functions')
<script type="text/javascript">

            $(document).ready(function(){
                @if(Auth::user()->estado_pass  == 1)
                $('#modal_ambito').modal({backdrop: 'static', keyboard: false})
                $('#modal_ambito').modal('show');
                $("[name='clave1']").attr("required", true);
                @endif
            });
</script>
@endpush
@can('SUPERADMINISTRADOR')

    {{-- Scripts necesarios para el formulario --}}
    @push('scripts')
        <!-- Char js -->
        <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('js/charts.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    @endpush

    {{-- Estilos necesarios para el formulario --}}

    @push('styles')
        <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    @endpush

    {{-- Funciones necesarias por el formulario --}}
    @push('functions')
        <script type="text/javascript">
            $(document).ready(function () {

                @if(session()->get('id_proceso') && isset($factoresDocumentales))
                @if($factoresDocumentales->isNotEmpty())

                //Documental
                $('#factor_documental').select2({
                    language: "es"
                });
                $('#caracteristica').select2({
                    language: "es"
                });
                $('#dependencia').select2({
                    language: "es"
                });
                $('#tipo_documento').select2({
                    language: "es"
                });

                limite = 6;

                $('#generar_reporte').on('click', function (e) {
                    $("#hidden_html").val(url_base64.join('|'));
                    $('#form_generar_pdf').submit();
                })

                selectDinamico("#factor_documental", "#caracteristica", "{{url('admin/documental/documentos_autoevaluacion/caracteristicas')}}", ['#indicador']);


                setTimeout(peticionGraficasDocumentales("{{ route('documental.informe_documental.datos') }}"), 3000);

                var form_documental = $('#form_filtros_documental');

                $("#factor_documental, #caracteristica, #dependencia, #tipo_documento").change(function () {
                    $.ajax({
                        url: form_documental.attr('action'),
                        type: form_documental.attr('method'),
                        data: form_documental.serialize(),
                        dataType: 'json',
                        success: function (r) {
                            ChartFiltro.destroy();
                            ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador',
                                r.labels_indicador, ['Cantidad'], r.data_indicador
                            );
                        }
                    });
                });

                //Encuestas

                var canvas = document.getElementById('pie_filtro');
                $('#grupos').select2({
                    language: "es"
                });
                $('#preguntas').select2({
                    language: "es"
                });
                $('#factor').select2({
                    language: "es"
                });
                selectDinamico("#grupos", "#preguntas", "{{url('admin/fuentesPrimarias/grupos/preguntas')}}", ['#preguntas']);
                peticionGraficasEncuestas("{{ route('primarias.informe_encuestas.datos') }}");
                var form = $('#form_filtros_encuestas');
                $("#preguntas").change(function () {
                    console.log('asssa');
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        dataType: 'json',
                        success: function (r) {
                            filtro.destroy();
                            filtro = crearGrafica('pie_filtro', 'doughnut', r.data_titulo, r.labels_respuestas, ['adasd'], r.data_respuestas);
                        }
                    });

                });
                $("#factor").change(function () {
                    console.log('asssa');
                    $.ajax({
                        url: "{{ route('primarias.informe_encuestas.filtrar_factores') }}",
                        type: form.attr('method'),
                        data: form.serialize(),
                        dataType: 'json',
                        success: function (r) {
                            caracteristicas.destroy();
                            caracteristicas = crearGrafica('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
                                ['Valorizacion'], r.data_caracteristicas);
                        }
                    });

                });
                @endif
                @endif
            });
        </script>

    @endpush
@endcan


