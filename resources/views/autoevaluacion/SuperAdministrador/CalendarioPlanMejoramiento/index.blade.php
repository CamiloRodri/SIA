{{-- Titulo de la pagina --}}
@section('title', 'Características')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
<!-- page content -->

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Calendario de Actividades </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id='calendar'></div>

                  </div>
                </div>
              </div>
            </div>

        <!-- /page content -->
    
    <!-- calendar modal -->
    <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Edit Calendar Entry</h4>
          </div>
          <div class="modal-body">

            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title2" name="title2">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
    <!-- /calendar modal -->



@push('scripts')
      <!-- FullCalendar -->
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/core/main.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/core/locales-all.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/interaction/main.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/daygrid/main.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/timegrid/main.js') }}"></script>
      <script src="{{ asset('gentella/vendors/fullcalendar/packages/list/main.js') }}"></script>
      <script>

        document.addEventListener('DOMContentLoaded', function() {
          var initialLocaleCode = 'es';
          var localeSelectorEl = document.getElementById('locale-selector');
          var calendarEl = document.getElementById('calendar');

          var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            defaultDate: '2019-08-12',
            locale: initialLocaleCode,
            buttonIcons: false, // show the prev/next text
            weekNumbers: true,
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
              {
                title: 'All Day Event',
                start: '2019-08-01'
              },
              {
                title: 'Long Event',
                start: '2019-08-07',
                end: '2019-08-10'
              },
              {
                groupId: 999,
                title: 'Repeating Event',
                start: '2019-08-09T16:00:00'
              },
              {
                groupId: 999,
                title: 'Repeating Event',
                start: '2019-08-16T16:00:00'
              },
              {
                title: 'Conference',
                start: '2019-08-11',
                end: '2019-08-13'
              },
              {
                title: 'Meeting',
                start: '2019-08-12T10:30:00',
                end: '2019-08-12T12:30:00'
              },
              {
                title: 'Lunch',
                start: '2019-08-12T12:00:00'
              },
              {
                title: 'Meeting',
                start: '2019-08-12T14:30:00'
              },
              {
                title: 'Happy Hour',
                start: '2019-08-12T17:30:00'
              },
              {
                title: 'Dinner',
                start: '2019-08-12T20:00:00'
              },
              {
                title: 'Birthday Party',
                start: '2019-08-13T07:00:00'
              },
              {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2019-08-28'
              }
            ]
          });

          calendar.render();

          // build the locale selector's options
          calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
            var optionEl = document.createElement('option');
            optionEl.value = localeCode;
            optionEl.selected = localeCode == initialLocaleCode;
            optionEl.innerText = localeCode;
            localeSelectorEl.appendChild(optionEl);
          });

          // when the selected option changes, dynamically change the calendar option
          localeSelectorEl.addEventListener('change', function() {
            if (this.value) {
              calendar.setOption('locale', this.value);
            }
          });

        });

      </script>
@endpush

@push('styles') 
    <link href="{{ asset('gentella/vendors/fullcalendar/packages/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('gentella/vendors/fullcalendar/packages/daygrid/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('gentella/vendors/fullcalendar/packages/timegrid/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('gentella/vendors/fullcalendar/packages/list/main.css') }}" rel='stylesheet' />
@endpush

@endsection
