{{-- Titulo de la pagina --}}
@section('title', 'Calificación Actividad de Mejoramiento')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content') @component('admin.components.panel')
    @slot('title', 'Calificación Actividad de Mejoramiento')
    <div class="col-md-12">
        @can('MODIFICAR_CALIFICA_ACTIVIDADES')
            <div class="actions">
                <a id="crear_ambitos" href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation" class="btn btn-info" data-toggle="modal" data-target="#modal_califica">
                    <i class="fa fa-pencil"></i> Editar Calificación </a></div>
    @endcan
    </div>
    @can('VER_CALIFICA_ACTIVIDADES')
        <br>
        <br>
        <br>
        <div class="col-md-12">
            @component('admin.components.datatable', ['id' => 'evidencia_table_ajax'])
            @slot('columns', [
            'id',
            'Nombre',
            'Fecha Subida',
            'Descripcion',
            'Archivo',
            '' => ['style' => 'width:0px;']
            ]) 
            @endcomponent
        </div>
        @endcomponent
    @endcan
@endsection
{{-- Scripts necesarios para el formulario --}}
@push('scripts')
    <!-- validator -->
    <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>



@endpush
{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
@endpush
{{-- Funciones necesarias por el formulario --}}
@push('functions')

@endpush