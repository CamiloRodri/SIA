{{-- Titulo de la pagina --}}
@section('title', 'Calificación Actividad de Mejoramiento')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel') 
    @slot('title', 'Calificación Actividad de Mejoramiento')
    <div>
        Puntuación para Calificar: 
        <img src="{{ asset('titan\assets\images\calificacion.png') }}" class="img-responsive" alt=""> </div>
    </div>
    <br>
    <br>
    <br>
    <hr>
    <div class="actions col-md-6">
        @can('CREAR_CALIFICA_ACTIVIDADES')
        {{-- <a href="{{ route('admin.evidencia.create', $actividad->PK_ACM_Id) }}" class="btn btn-info">
        <i class="fa fa-plus"></i> Calificar {{ $actividad->ACM_Nombre }} </a></div> --}}
        <div class="actions">
            <a id="calificar_actividad" href="#" class="btn btn-info" data-toggle="modal" data-target="#modal_cal_actividad">
                <i class="fa fa-plus"></i> Calificar {{ $actividad->ACM_Nombre }} 
            </a>
        </div>
        @endcan
    </div>

    <div class="col-md-6">
        <div class="actions">
            <a href="{{ route('admin.actividades_mejoramiento.index') }}" class="btn btn-warning">
            <i class="fa fa-backward"></i> Regresar a las actividades </a></div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="modal_cal_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_titulo">Calificar Actividad de Mejoramiento</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open([ 'route' => 'admin.califica_actividad.store',
                    'method' => 'POST', 'id' => 'form_cal_actividad', 'class' => 'form-horizontal
                        form-label-lef', 'novalidate' ])!!}
                    @include('autoevaluacion.SuperAdministrador.CalificaActividades.form')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Calificar
                    Actividad', ['class' => 'btn btn-success', 'id' => 'accion']) !!}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--FIN Modal CREAR-->
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
    @endcan
    
    @endcomponent
@endsection

{{-- Scripts necesarios para el formulario --}}
@push('scripts')
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
@endpush @push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            if({{ Session::get('calificacion') }} != null){
                new PNotify({
                    title: 'Ultima Calificación',
                    text: '<span style="font-size: 1.2em;">Ponderación: {{ Session::get('calificacion') }} </span>'+
                    '<br><span style="font-size: 1.2em;">Observación: </span> {{ Session::get('observacion') }}',
                    type: 'info',
                    hide: true,
                    styling: 'bootstrap3'
                });
            }
            var formCreate = $('#form_cal_actividad');
            $('#calificar_actividad').click(function () {
                $(formCreate)[0].reset();
                $('.modal-title').text("Calificar Actividad");
                $('#accion').val("Calificar");
                $('#accion').removeClass('modificar')
            });

            let sesion = sessionStorage.getItem("update");
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Calificación Modificada!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#evidencia_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: false,
                dom: 'lBfrtip',
                responsive: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ url('admin/califica_actividad/data/data') }}" + "/" + '{{ $actividad->PK_ACM_Id }}',
                "columns": [
                    {data: 'PK_EVD_Id', name: 'id', "visible": false},
                    {data: 'EVD_Nombre', name: 'Nombre', className: "all"},
                    {data: 'EVD_Fecha_Subido', name: 'Fecha Evidencia', className: "desktop"},
                    {data: 'EVD_Descripcion_General', name: 'Descripción General', className: "min-tablet-l"},
                    {data: 'archivo', name: 'Archivo', className: "ALL"},
                    {
                        defaultContent:
                            '@can('ELIMINAR_CALIFICA_ACTIVIDADES')@endcan' +
                            '@can('MODIFICAR_CALIFICA_ACTIVIDADES')@endcan',
                        data: 'action',
                        name: 'action',
                        title: '',
                        orderable: false,
                        searchable: false,
                        exportable: false,
                        printable: false,
                        className: 'text-right',
                        render: null,
                        responsivePriority: 2
                    }
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                initComplete: function () {
                    this.api().columns([1, 3]).every(function () {
                        var column = this;
                        var select = $('<select style="width: 100px;"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                    });
                }

                // $(document).on('submit', '#form_cal_actividad', function (e) {
                // e.preventDefault();
                // let route = formCreate.attr('action');
                // let method = formCreate.attr('method');
                // let data = formCreate.serialize();
                // if ($('#accion').hasClass('modificar')) {
                //     route = '{{ url('admin/actividades_mejoramiento/califica_actividad') }}' + '/' + $('#PK_AMB_Id').val() + '/edit';
                //     method = "PUT";
                // }
                // $.ajax({
                //     url: route,
                //     type: method,
                //     data: data,
                //     dataType: 'json',
                //     success: function (response, NULL, jqXHR) {
                //         $(formCreate)[0].reset();
                //         $(formCreate).parsley().reset();
                //         $('#modal_ambito').modal('hide');
                //         new PNotify({
                //             title: response.title,
                //             text: response.msg,
                //             type: 'success',
                //             styling: 'bootstrap3'
                //         });
                //         table.ajax.reload();
                //     },
                //     error: function (data) {
                //         var errores = data.responseJSON.errors;
                //         var msg = '';
                //         $.each(errores, function (name, val) {
                //             msg += val + '<br>';
                //         });
                //         new PNotify({
                //             title: "Error!",
                //             text: msg,
                //             type: 'error',
                //             styling: 'bootstrap3'
                //         });
                //     }
                // });

            });

            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/evidencia/') }}' + '/' + dataTable.PK_EVD_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_EVD_Id, route);
            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/evidencia') }}' + '/' + dataTable.PK_EVD_Id + '/edit';
                window.location.href = route;
            });
            
            @if (session('status'))
            new PNotify({
                tittle:'Campos Incompletos',
                text:'Debe agregar una Calificación y Observación',
                type:'error',
                styling:'bootstrap3'
	        });
	        @endif

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "La Evidencia sera eliminada permanentemente!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                showLoaderOnConfirm: true,
                cancelButtonText: "Cancelar",
                preConfirm: function () {
                    return new Promise(function (resolve) {

                        $.ajax({
                            type: 'DELETE',
                            url: route,
                            data: {
                                '_token': $('meta[name="_token"]').attr('content'),
                            },
                            success: function (response, NULL, jqXHR) {
                                table.ajax.reload();
                                new PNotify({
                                    title: response.title,
                                    text: response.msg,
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });
                            }
                        })
                            .done(function (response) {
                                swal('Eliminado exitosamente!', response.message, response.status);
                            })
                            .fail(function () {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }


    </script>



@endpush