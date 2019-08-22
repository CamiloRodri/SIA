@extends('admin.layouts.pdf_layout')
@section('titulo_documento', 'Reporte general del proceso ' . session('proceso'))

@section('contenido_pdf') @if(session()->get('id_proceso'))
    <h2>Proceso Documental</h2>
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
    <div class="row">
        <h2>Proceso Encuestas</h2>
    </div>

    <div class="row">
        <div class="col-xs-15">
            <img src="{{ $imagenes[0] }}" style="width:1200px; height:400px;" alt="Responsive image">
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-xs-15">
            <img src="{{ $imagenes[1] }}" style="width:1000px; height:400px;" alt="Responsive image">
        </div>
    </div>
    <br><br>
    <div class="row">
        <img src="{{ $imagenes[2] }}" style="width:700px; height:400px;" alt="Responsive image">
    </div>

@else Por favor seleccione un proceso @endif
@endsection