{{-- Titulo de la pagina --}}
@section('title', 'Características')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
<!-- page content -->

            <!-- Main view: Title and calendar -->


<select id="dropdown">
   <option value="Those" data-feed="https://rawgit.com/konsumkunst/17f101d0ee66e2b22cf23299a0abf1f3/raw/adb4037227a1e94c8c4f366087b38d36c56edfe8/thoseevents.json" selected>Those</option>
   <option value="Them" data-feed="https://rawgit.com/konsumkunst/8ce713ae61c929cbbd2063b46e70278e/raw/4faa698cf29df0868983d5b75321e2043c8de6a5/themevents.json">Them</option>
</select>

<div id="wrapper">
  <div id="loading"></div>
  <div id="calendar"></div>
</div>

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
            defaultDate: '2017-08-01',
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