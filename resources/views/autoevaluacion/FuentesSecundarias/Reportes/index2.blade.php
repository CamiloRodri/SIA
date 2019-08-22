{{-- Titulo de la pagina --}}
@section('title', 'Reportes documentales')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Reportes documentales')
        <form target="_blank" id="form_generar_pdf" action="{{ route('documental.informe_institucionales.descargar') }}"
              method="post">
            @csrf
            <input type="hidden" name="json_datos" id="hidden_html"/>
            <button class="btn btn-danger" id="generar_reporte"><i class="fa fa-file-pdf-o"></i> Generar Reporte
            </button>
        </form>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <canvas id="documentos_institucionales" height="220"></canvas>
            </div>
            <div class="col-md-6 col-xs-12">
                <canvas id="historial_institucionales" height="220"></canvas>
            </div>
        </div>

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
            limite = 3;

            $('#generar_reporte').on('click', function (e) {
                $("#hidden_html").val(url_base64.join('|'));
                $('#form_generar_pdf').submit();
            })

            $.ajax({
                url: "{{ route('documental.informe_documental.data') }}",
                type: 'GET',
                dataType: 'json',
                success: function (r) {
                    crearGrafica('historial_institucionales', 'line', 'Historial Documentos institucionales',
                        r.labels_fecha, ['cantidad'], r.data_fecha
                    );
                    ChartFiltro = crearGrafica('documentos_institucionales', 'pie', 'Documentos institucionales',
                        r.labels_documento, ['cantidad'], r.data_documento
                    );
                }
            });

        });


    </script>
@endpush