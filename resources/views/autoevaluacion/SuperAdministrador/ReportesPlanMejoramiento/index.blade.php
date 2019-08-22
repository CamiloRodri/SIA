{{-- Titulo de la pagina --}}
@section('title', 'Reportes Plan de Mejoramiento')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Reportes Plan de Mejoramiento')
        @if(session()->get('id_proceso'))
            <div id="graficas" class="hidden">
                <div class="row">
                    {!! Form::open([
                            'route' => 'admin.informes_mejoramiento.filtrar_factores',
                            'method' => 'POST',
                            'id' => 'form_filtros',
                            'class' => 'form-horizontal form-label-left',
                            'novalidate'
                    ])!!}
                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <hr/>
                        </div>
                        <canvas id="caracteristicas" height="70"></canvas>
                        <br>
                        <br>
                        @include('autoevaluacion.SuperAdministrador.ReportesPlanMejoramiento._form')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
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
            @if(session()->get('id_proceso'))
            $('#factor').select2({
                language: "es"
            });

            peticionGraficasMejoramiento("{{ route('admin.informes_mejoramiento.datos') }}");

            var form = $('#form_filtros');
            $("#factor").change(function () {
                console.log('asssa');
                $.ajax({
                    url: "{{ route('admin.informes_mejoramiento.filtrar_factores') }}",
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (r) {
                        caracteristicas.destroy();
                        caracteristicas = crearGrafica('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
                            ['Valorizacion de Caracteristicas'], r.data_caracteristicas);
                    }
                });

            });
            @endif
        });
    </script>
@endpush