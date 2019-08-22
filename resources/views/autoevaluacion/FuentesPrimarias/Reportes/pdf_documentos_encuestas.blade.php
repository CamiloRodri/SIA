@extends('admin.layouts.pdf_layout')

@section('titulo_documento', 'Reporte Consolidacion de Encuestas ' . session('proceso'))

@section('contenido_pdf')

    @if(session()->get('id_proceso'))
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
    @else
        Por favor seleccione un proceso
    @endif

@endsection
