{{-- Titulo de la pagina --}}
@section('title', 'Valorizacion de Caracteristicas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    {{-- @component('admin.components.panel_collapse') --}}
    <div class="x_panel">
        <div class="x_title">
            <h2>
                Valorizacion de Caracteristicas - Encuestas
            </h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link" ><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix">
            </div>
        </div>
        @if(session()->get('id_proceso'))
            @if(isset($planMejoramiento))
                <div class="col-md-12">
                    <div class="actions">
                        <a href="{{ route('admin.informes_mejoramiento') }}" class="btn btn-info">
                            <i class="fa fa-plus"></i>Ver Reporte
                        </a>
                    </div>
                </div>
                <br>
                <br>
                <br>
                @can('VER_VALORIZACION_CARACTERISTICAS')
                    <div class="x_content">
                        <div class="col-md-12">
                            @component('admin.components.datatable', ['id' => 'caracteristicas_mejoramiento_table_ajax']) @slot('columns', [
                                'id',
                                'Caracteristica',
                                'Descripcion',
                                'Identificador',
                                'Factor',
                                'Ambito',
                                'Valorizacion',
                                'Calificacion',
                                'Acciones' => ['style' => 'width:50px;']])
                            @endcomponent
                        </div>
                    </div>
                @endcan
    </div>

    <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Valorizacion de Caracteristicas - Documentos Autoevaluación
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link" ><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix">
                    </div>
                </div>
                @can('VER_VALORIZACION_CARACTERISTICAS')
                    <div class="x_content">
                        <div class="col-md-12">
                            @component('admin.components.datatable', ['id' => 'caracteristicas_mejoramiento_doc_table_ajax']) @slot('columns', [
                                'id',
                                'Nombre',
                                'Caracteristica',
                                'Factor',
                                'identificador',
                                'Numero',
                                'Descripcion',
                                'Observaciones',
                                'Valorizacion',
                                'Calificacion',
                                'Acciones' => ['style' => 'width:50px;']])
                            @endcomponent
                        </div>
                    </div>
                @endcan
    </div>
            @else
                Este proceso aun no tiene plan de mejoramiento.
            @endIf
        @else
            Por favor seleccione un proceso
        @endif
    {{-- @endcomponent --}}
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

                    @if(session()->get('id_proceso'))
            let sesion = sessionStorage.getItem("update");
            if (sesion != null) {
                sessionStorage.clear();
                new PNotify({
                    title: "Actividad Modificada!",
                    text: sesion,
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
            table = $('#caracteristicas_mejoramiento_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('admin.caracteristicas_mejoramiento.data') }}",
                "columns": [
                    {data: 'PK_CRT_Id', name: 'id', "visible": false},
                    {data: 'CRT_Nombre', name: 'Caracteristica', className: "min-phone-l"},
                    {data: 'CRT_Descripcion', name: 'Descripcion', className: "min-phone-l"},
                    {data: 'CRT_Identificador', name: 'Identificador', className: "min-phone-l"},
                    {data: 'factor.FCT_Nombre', name: 'Factor', className: "all"},
                    {data: 'Ambito', name: 'Ambito', className: "min-phone-l"},
                    {data: 'Valorizacion', name: 'Valorizacion', className: "min-phone-l"},
                    {data: 'Calificacion', name: 'Calificacion', className: "min-phone-l"},
                    {
                        defaultContent:
                            '@can('CREAR_ACTIVIDADES_MEJORAMIENTO')<a data-toggle="tooltip" title="Crear Actividades de Mejoramiento " href="javascript:;" class="btn btn-simple btn-primary btn-sm asignar"><i class="fa fa-plus"></i></a>@endcan',
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
                    this.api().columns([4]).every(function () {
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
            table.on('click', '.asignar', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento/') }}' + '/' + dataTable.PK_CRT_Id;
                window.location.href = route;
            });

            table_2 = $('#caracteristicas_mejoramiento_doc_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('admin.caracteristicas_mejoramiento.data_doc') }}",
                "columns": [
                    {data: 'PK_DOA_Id', name: 'id', "visible": false},
                    {data: 'nombre',name: 'Nombre',className: "min-tablet-l"},
                    {data: 'nombre_caracteristica',name: 'Caracteristica',className: "min-tablet-l"},
                    {data: 'nombre_factor',name: 'Factor',className: "all"},
                    {data: 'identificador',name: 'Factor',className: "all"},
                    {data: 'DOA_Numero', name: 'Numero', className: "min-phone-l"},
                    {data: 'DOA_DescripcionGeneral', name: 'Descripcion', className: "min-phone-l"},
                    {data: 'DOA_Observaciones', name: 'Observaciones', className: "min-phone-l"},
                    {data: 'DOA_Calificacion', name: 'Valorizacion', className: "min-phone-l"},
                    {data: 'Calificacion', name: 'Calificacion', className: "min-phone-l"},
                    {
                        defaultContent:
                            '@can('CREAR_ACTIVIDADES_MEJORAMIENTO')<a data-toggle="tooltip" title="Crear Actividades de Mejoramiento " href="javascript:;" class="btn btn-simple btn-primary btn-sm asignar_table_2"><i class="fa fa-plus"></i></a>@endcan',
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
                    this.api().columns([4]).every(function () {
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
            table_2.on('click', '.asignar_table_2', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table_2.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento/') }}' + '/' + dataTable.identificador;
                window.location.href = route;
            });
            @endif
        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "El Aspecto sera eliminado permanentemente!",
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
