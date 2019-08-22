{{-- Titulo de la pagina --}}
@section('title', 'Preguntas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Establecer Preguntas')
        @can('CREAR_ESTABLECER_PREGUNTAS')
            <div class="col-md-12">
                <div class="actions">
                    <a href="{{ route('fuentesP.establecerPreguntas.create') }}" class="btn btn-info">
                        <i class="fa fa-plus"></i> Agregar Pregunta</a>
                    {{ link_to_route('fuentesP.bancoEncuestas.index'," Volver ", [], ['class' => 'fa fa-hand-o-left btn btn-warning']) }}
                </div>
            </div>
            <br>
            <br>
            <br>
        @endcan

        @can('VER_ESTABLECER_PREGUNTAS')
            <div class="col-md-12">
                @component('admin.components.datatable', ['id' => 'establecerPreguntas-table-ajax']) @slot('columns', [ 'id', 'Pregunta','Estado','Tipo Respuesta','Caracteristica',
                'Grupo de Interes',
    'Acciones' => ['style' => 'width:85px;'] ]) @endcomponent

            </div>
            @endcomponent
        @endcan
@endsection
@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

@endpush
@push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

@endpush
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            let sesion = sessionStorage.getItem("update");
            console.log(sesion);
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Datos Modificados!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });

            }
            table = $('#establecerPreguntas-table-ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('fuentesP.establecerPreguntas.data') }}",
                "columns": [
                    {data: 'PK_PEN_Id', name: 'id', "visible": false},
                    {data: 'preguntas.PGT_Texto', name: 'Pregunta', className: "all"},
                    {data: 'estado', name: 'estado', className: "all"},
                    {data: 'preguntas.tipo.TRP_Descripcion', name: 'Tipo Respuesta', className: "all"},
                    {data: 'preguntas.caracteristica.CRT_Nombre', name: 'Caracteristica', className: "all"},
                    {data: 'grupos.GIT_Nombre', name: 'Grupo de Interes', className: "all"},
                    {
                        defaultContent:
                            '@can('ELIMINAR_ESTABLECER_PREGUNTAS')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                            '@can('MODIFICAR_ESTABLECER_PREGUNTAS')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan',
                        data: 'action',
                        name: 'action',
                        title: 'Acciones',
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
                    this.api().columns([4, 5]).every(function () {
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
            });
            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/establecerPreguntas/') }}' + '/' + dataTable.PK_PEN_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_PEN_Id, route);

            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/fuentesPrimarias/establecerPreguntas/') }}' + '/' + dataTable.PK_PEN_Id + '/edit';
                window.location.href = route;

            });
        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "Los datos seran eliminados permanentemente!",
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
                            },
                            error: function (data) {
                                var errores = data.responseJSON.errors;
                                var msg = '';
                                $.each(errores, function (name, val) {
                                    msg += val + '<br>';
                                });
                                new PNotify({
                                    title: "Error!",
                                    text: msg,
                                    type: 'error',
                                    styling: 'bootstrap3'
                                });
                            }
                        })
                            .done(function (response) {
                                swal('Pregunta eliminada exitosamente!', response.message, response.status);
                            })
                            .fail(function () {
                                swal('Error', 'La pregunta hace parte de una encuesta en uso para un proceso que se encuentra en fase de captura de datos!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

    </script>

@endpush