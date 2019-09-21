{{-- Titulo de la pagina --}}
@section('title', 'Procesos')

{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Procesos de autoevaluación de programas')
        @can('CREAR_PROCESOS_PROGRAMAS')
            <div class="col-md-12">
                <div class="actions">
                    <a href="{{ route('admin.procesos_programas.create') }}" class="btn btn-info">
                        <i class="fa fa-plus"></i> Agregar Proceso</a></div>
            </div>
            <br>
            <br>
            <br>
        @endcan
        @can('VER_PROCESOS_PROGRAMAS')
            <div class="col-md-12">
                @component('admin.components.datatable',
                ['id' => 'procesos_programas_table_ajax'])
                    @slot('columns',
                    [ 'id',
                    'Sede',
                    'Facultad',
                    'Programa',
                    'Proceso',
                    'Inicio',
                    'Fin',
                    'Fase',
                    'Acciones' => ['style' => 'width:125px;']])
                @endcomponent

            </div>
            @endcomponent
        @endcan

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
@endpush
{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {


            let sesion = sessionStorage.getItem("update");
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Proceso Modificado!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#procesos_programas_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: false,
                dom: 'lBfrtip',
                responsive: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": {
                    "url": "{{ route('admin.procesos_programas.data') }}",
                    complete: function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                },
                "columns": [
                    {data: 'PK_PCS_Id', name: 'id', "visible": false},
                    {data: 'programa.sede.SDS_Nombre', name: 'Sede', className: "all"},
                    {data: 'programa.facultad.FCD_Nombre', name: 'Facultad', className: "min-phone-l"},
                    {data: 'programa.PAC_Nombre', name: 'Programa', className: "min-tablet-l"},
                    {data: 'PCS_Nombre', name: 'Proceso', className: "min-phone-l"},
                    {data: 'PCS_FechaInicio', name: 'Inicio', className: "desktop"},
                    {data: 'PCS_FechaFin', name: 'Fin', className: "desktop"},
                    {data: 'fase.FSS_Nombre', name: 'Fase', className: "desktop"},
                    {
                        defaultContent:
                            '@can('ELIMINAR_PROCESOS_PROGRAMAS')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                            '@can('MODIFICAR_PROCESOS_PROGRAMAS')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan' +
                            '@can('ASIGNAR_FRENTE_ESTRATEGICO_INSTITUCION')<a data-toggle="tooltip" title="Asignar usuarios" href="javascript:;" class="btn btn-simple btn-info btn-sm asignar"><i class="fa fa-plus"></i></a>@endcan',
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
                    this.api().columns([1, 2, 3]).every(function () {
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
                var route = '{{ url('admin/procesos_programas') }}' + '/' + dataTable.PK_PCS_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_PCS_Id, route);

            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/procesos_programas/') }}' + '/' + dataTable.PK_PCS_Id + '/edit';
                window.location.href = route;
            });
            table.on('click', '.asignar', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/procesos_usuarios/proceso') }}' + '/' + dataTable.PK_PCS_Id;
                window.location.href = route;
            });

        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El proceso sera eliminado permanentemente!",
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