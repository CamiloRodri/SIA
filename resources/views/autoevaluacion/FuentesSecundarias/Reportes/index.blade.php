{{-- Titulo de la pagina --}}
@section('title', 'Reportes documentales')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Reportes documentales')
        @if(session()->get('id_proceso') && isset($factores))
            @if($factores->isNotEmpty())

                <div id="graficas" class="hidden">

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
                    <form target="_blank" id="form_generar_pdf"
                          action="{{ route('documental.informe_documental.descargar') }}" method="post">
                        @csrf
                        <input type="hidden" name="json_datos" id="hidden_html"/>
                        <button class="btn btn-danger" id="generar_reporte"><i class="fa fa-file-pdf-o"></i> Generar
                            Reporte
                        </button>
                    </form>

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
                                'id' => 'form_filtros',
                                'class' => 'form-horizontal form-label-left',
                                'novalidate'
                        ])!!}
                        <div class="col-xs-12">
                            @include('autoevaluacion.FuentesSecundarias.Reportes._form')

                            <div class="col-xs-12">
                                <hr/>
                            </div>
                            <canvas id="documentos_indicador" height="150"></canvas>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @else
                El proceso aun no tiene datos para mostrar.
            @endif
        @else
            Por favor seleccione un proceso
        @endif

    @endcomponent



@endsection

{{-- Scripts necesarios para el formulario --}}
@push('scripts')
    <!-- Char js -->
    <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endpush

{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(session()->get('id_proceso') && isset($factores))
            @if($factores->isNotEmpty())
            $('#factor').select2({
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
            selectDinamico("#factor", "#caracteristica", "{{url('admin/documental/documentos_autoevaluacion/caracteristicas')}}", ['#indicador']);

            limite = 3;
            peticionGraficasDocumentales("{{ route('documental.informe_documental.datos') }}");

            var form = $('#form_filtros');

            $("#factor, #caracteristica, #dependencia, #tipo_documento").change(function () {
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (r) {
                        ChartFiltro.destroy();
                        ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador',
                            r.labels_indicador, ['Cantidad'], r.data_indicador
                        );
                    }
                });

            });

            $('#generar_reporte').on('click', function (e) {
                $("#hidden_html").val(url_base64.join('|'));
                $('#form_generar_pdf').submit();
            })
            @endif
            @endif


        });
    </script>
@endpush