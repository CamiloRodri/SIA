@extends('admin.layouts.pdf_layout')

@section('titulo_documento', 'Reporte documentos autoevaluación del proceso ' . session('proceso'))

@section('contenido_pdf')

    @if(session()->get('id_proceso'))
        <div class="row">
            <div class="col-xs-6">
                <img src="{{ $imagenes[0] }}" style="width:400px; height:400px;" alt="Responsive image">
            </div>
            <div class="col-xs-6">
                <img src="{{ $imagenes[1] }}" style="width:400px; height:400px;" alt="Responsive image">
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <img src="{{ $imagenes[2] }}" style="width:800px; height:600px;" alt="Responsive image">
        </div>
    @else
        Por favor seleccione un proceso
    @endif

@endsection
