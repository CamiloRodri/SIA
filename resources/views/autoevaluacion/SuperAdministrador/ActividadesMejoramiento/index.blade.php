{{-- Titulo de la pagina --}}
@section('title', 'Actividades de Mejoramiento')
 {{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Actividades de Mejoramiento')
        @if(session()->get('id_proceso'))
            @if(isset($planMejoramiento))
                @can('VER_ACTIVIDADES_MEJORAMIENTO')
                    <div class="col-md-12">
                        @include('autoevaluacion.SuperAdministrador.ActividadesMejoramiento._form_fecha_corte')
                        @component('admin.components.datatable', ['id' => 'actividades_mejoramiento_table_ajax']) @slot('columns', [
            'id','Factor','Caracteristica','Actividad', 'Descripcion', 'Fecha de Inicio', 'Fecha de Finalizacion', 'Responsable','Estado',
            'Acciones' => ['style' => 'width:85px;']]) @endcomponent
                    </div>
                @endcan
            @else
                Este proceso aun no tiene plan de mejoramiento.
            @endif
        @else
            Por favor seleccione un proceso
        @endif
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
                table = $('#actividades_mejoramiento_table_ajax').DataTable({
                    processing: true,
                    serverSide: false,
                    stateSave: true,
                    keys: true,
                    dom: 'lBfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                    "ajax": "{{ route('admin.actividades_mejoramiento.data') }}",
                    "columns": [
                        {data: 'PK_ACM_Id', name: 'id', "visible": false},
                        {data: 'caracteristicas.factor.FCT_Nombre', name: 'Factor', className: "min-phone-l"},
                        {data: 'caracteristicas.CRT_Nombre', name: 'Caracteristica', className: "min-phone-l"},
                        {data: 'ACM_Nombre', name: 'Actividad', className: "min-phone-l"},
                        {data: 'ACM_Descripcion', name: 'Descripcion', className: "min-phone-l"},
                        {data: 'ACM_Fecha_Inicio', name: 'Fecha de Inicio', className: "min-phone-l"},
                        {data: 'ACM_Fecha_Fin', name: 'Fecha de Finalizacion', className: "all"},
                        {data: 'responsable', name: 'Responsable', className: "all"},
                        {data: 'estado', name: 'Estado', className: "all"},
                        {
                            defaultContent:
                                '@can('ELIMINAR_ACTIVIDADES_MEJORAMIENTO')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                                '@can('MODIFICAR_ACTIVIDADES_MEJORAMIENTO')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan' +
                                '@can('ACCEDER_EVIDENCIA')<a data-toggle="tooltip" title="Agregar Evidencia" href="javascript:;" class="btn btn-simple btn-primary btn-sm asignar"><i class="fa fa-plus"></i></a>@endcan' +
                                '@can('ACCEDER_CALIFICA_ACTIVIDADES')<a data-toggle="tooltip" title="Calificar actividad" href="javascript:;" class="btn btn-simple btn-info btn-sm calificar"><i class="fa fa-book"></i></a>@endcan',
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
                    "sLengthMenu": "Mostrar MENU registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del START al END de un total de TOTAL registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de MAX registros)",
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
             });
             table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento') }}' + '/' + dataTable.PK_ACM_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_ASP_Id, route);
             });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento/') }}' + '/' + dataTable.PK_ACM_Id + '/edit';
                window.location.href = route;
             });
             table.on('click', '.asignar', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento/evidencia/') }}' + '/' + dataTable.PK_ACM_Id;
                window.location.href = route;
            });
            table.on('click', '.calificar', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/actividades_mejoramiento/califica_actividad') }}' + '/' + dataTable.PK_ACM_Id;
                window.location.href = route;
            });

            @if (session('status'))
            new PNotify({
                tittle:'Calificación Almacenada',
                text:'Se ha calificado la actividad de mejoramiento',
                type:'success',
                styling:'bootstrap3'
	        });
	        @endif
            @if (session('error'))
            new PNotify({
                tittle:'Error',
                text:'Usted no es responsable de esta actividad de mejoramiento.',
                type:'error',
                styling:'bootstrap3'
	        });
	        @endif
            @endif
        });
         function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "La actividad de mejoramiento sera eliminada permanentemente!",
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
                                swal('Eliminada exitosamente!', response.message, response.status);
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