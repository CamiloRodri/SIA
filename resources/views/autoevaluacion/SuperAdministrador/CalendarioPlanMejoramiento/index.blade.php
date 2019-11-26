{{-- Titulo de la pagina --}}
@section('title', 'Calendario')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
<!-- page content -->

@if(session()->get('id_proceso'))
            @if(isset($planMejoramiento))
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Calendario de Actividades de Mejoramiento</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>

                    <div class="item form-group">
                        <div class="col-md-3">
                            <br><br>    
                            {{-- <select id='locale-selector'></select>  --}}
                            <h4>Actividad: </h4> 

                                  {{-- <div class="item form-group">
                                    {!! Form::select('PK_ACT_Id', $actividades, 
                                      old('PK_ACM_Id', isset($actividad)? $actividad->PK_ACM_Nombre:''), [
                                        'placeholder' => 'Seleccione una Actividad',
                                        'class' => 'select2_user form-control', 
                                        'required']) 
                                    !!} --}}

                                    {{-- <select id='actividad-selector' class="bs-select form-control" data-width="75%" name="autor_id">
                                            @foreach($actividades as $actividad)
                                                <option value="{{$actividad->PK_ACT_Id}}">{{$actividad->ACM_Nombre}}</option>
                                            @endforeach
                                    </select> --}}

                                    <select id="dropdown" class="bs-select form-control" data-width="75%" >
                                       {{-- <option value="Those" data-feed="https://rawgit.com/konsumkunst/17f101d0ee66e2b22cf23299a0abf1f3/raw/adb4037227a1e94c8c4f366087b38d36c56edfe8/thoseevents.json" selected>Those</option> --}}
                                        @foreach($actividades as $actividad)
                                           <option value="Them" data-feed="{{ $actividad->json }}">{{ $actividad->ACM_Nombre }}</option>  
                                        @endforeach                                   
                                    </select>
                           </div>
                        </div>
                        <div class="col-md-9">
                            <div class="x_content" >
                              <div id="wrapper">
                                <div id="loading"></div>
                                <div id="calendar"></div>
                              </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>
              </div>
              @include('autoevaluacion.SuperAdministrador.CalendarioPlanMejoramiento._modal');
            @else
                @component('admin.components.panel')
                  @slot('title', 'Calendario de Actividades')
                  Este proceso aun no tiene plan de mejoramiento.
                @endcomponent
            @endif
        @else
            @component('admin.components.panel')
                @slot('title', 'Calendario de Actividades')
                Por favor seleccione un proceso
            @endcomponent
        @endif


        <!-- /page content -->


@push('scripts')
      <!-- FullCalendar -->
      <script src="{{ asset('gentella/vendors/moment/min/moment.min.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar2.7.3/dist/fullcalendar.min.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar2.7.3/dist/lang/es.js') }}"></script>
      <script>
        var selectedFeed = $('#dropdown').find(':selected').data('feed');
        $('#calendar').fullCalendar({
            locale:'es',
            editable: false,
            firstDay: 1,
            displayEventTime: false,
            //defaultDate: '2017-08-01',
            defaultDate: new Date(),
            eventSources: [ selectedFeed ],
            eventLimit: 3,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listWeek'
            },
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            loading: function(bool) {
              if (bool) {
                $(this).parent().find('#loading').fadeIn( "300");
              }else {
                $(this).parent().find('#loading').fadeOut( "300");
              }
            }
        });

        $('#dropdown').change(onSelectChangeFeed);

        function onSelectChangeFeed() { 
            var feed = $(this).find(':selected').data('feed');
            $('#calendar').fullCalendar('removeEventSource', selectedFeed);
            $('#calendar').fullCalendar('addEventSource', feed);  
            selectedFeed = feed;
        };
     </script>
@endpush

@push('styles') 
    <link href="{{ asset('gentella/vendors/fullcalendar2.7.3/dist/fullcalendar.min.css') }}" rel="stylesheet">
      <link href="{{ asset('gentella/vendors/fullcalendar2.7.3/dist/fullcalendar.print.css') }}" rel="stylesheet" media="print">
@endpush

@endsection