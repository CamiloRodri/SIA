@extends('admin.layouts.pdf_layout')
@section('titulo_documento', 'Reporte documentos institucionales')

@section('contenido_pdf')
    <div class="row">
        <div class="col-xs-6">
            <img src="{{ $imagenes[0] }}" style="width:400px; height:400px;" alt="Responsive image">
        </div>
        <div class="col-xs-6">
            <img src="{{ $imagenes[1] }}" style="width:400px; height:400px;" alt="Responsive image">
        </div>
    </div>
@endsection