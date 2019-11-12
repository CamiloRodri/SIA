@extends('public.layouts.app')
@section('content')
    <section class="bg-dark-30 showcase-page-header module parallax-bg"
             data-background="{{ asset('titan/assets/images/fondo_2.jpg') }}">
        <div class="titan-caption">
            <div class="caption-content">
                <div class="font-alt mb-30 titan-title-size-1">Autoevaluación y acreditación</div>
                <div class="font-alt mb-40 titan-title-size-4">Sistema de información de Autoevaluación v 4.0</div>
            </div>
        </div>
    </section>
    <div class="titan-caption">
        <div class="caption-content">
            @if ($encuestas->count() != 0)
            </br>
            @foreach ($encuestas as $encuesta)
                @if($encuesta->proceso->programa)
                    <a href="/grupos/{{ $encuesta->proceso->PCS_Slug_Procesos }}" class="btn btn-d btn-round">
                        Inicio&nbsp;{{$encuesta->proceso->nombre_proceso}}&nbsp;{{$encuesta->proceso->programa->PAC_Nombre}}</a>
                @else
                    <a href="/grupos/{{ $encuesta->proceso->PCS_Slug_Procesos }}" class="btn btn-d btn-round">
                        Inicio&nbsp;{{$encuesta->proceso->nombre_proceso}}</a>
                @endif
            @endforeach
            <br></br>
            @endif
        </div>
    </div>
@endsection