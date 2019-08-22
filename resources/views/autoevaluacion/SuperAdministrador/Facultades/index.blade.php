{{-- Titulo de la pagina --}}
@section('title', 'Facultades')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content') @component('admin.components.panel')
    @slot('title', 'Facultades')
    <div class="col-md-12">
        @can('CREAR_FACULTADES')
            <div class="actions">
                <a id="crear_facultad" href="#" class="btn btn-info" data-toggle="modal" data-target="#modal_facultad">
                    <i class="fa fa-plus"></i> Agregar Facultad</a></div>
    @endcan
    <!-- Modal-->
        <div class="modal fade" id="modal_facultad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_titulo">Crear Facultad</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::open([ 'route' => 'admin.facultades.store',
                        'method' => 'POST', 'id' => 'form_facultades', 'class' => 'form-horizontal
                            form-label-lef', 'novalidate' ])!!}
                        @include('autoevaluacion.SuperAdministrador.Facultades._form')

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        {!! Form::submit('Crear
                        Facultad', ['class' => 'btn btn-success', 'id' => 'accion']) !!}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--FIN Modal CREAR-->

    </div>
    @can('VER_FACULTADES')
        <br>
        <br>
        <br>
        <div class="col-md-12">
            @component('admin.components.datatable',
            ['id' => 'facultades_table_ajax'])
                @slot('columns', [ 'id', 'Nombre', 'Descripción','Estado', 'Acciones' =>
                ['style' => 'width:85px;'] ])
            @endcomponent

        </div>
        @endcomponent
    @endcan
@endsection
{{-- Scripts necesarios para el formulario --}}
@push('scripts')
    <!-- validator -->
    <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
    <!-- Datatables -->
    <script src="{{asset('gentella/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{asset('gentella/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>



@endpush
{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <!-- Datatables -->
    <link href="{{ asset('gentella/vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endpush
{{-- Funciones necesarias por el formulario --}}
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#estado').select2();
            var formCreate = $('#form_facultades');
            $('#crear_facultad').click(function () {
                $(formCreate)[0].reset();
                $('.modal-title').text("Crear Facultad");
                $('#accion').val("Crear");
                $('#accion').removeClass('modificar')
            });
            var data, routeDatatable;
            data = [
                {data: 'PK_FCD_Id', name: 'id', "visible": false},
                {data: 'FCD_Nombre', name: 'Nombre', className: "min-table-p"},
                {data: 'FCD_Descripcion', name: 'Descripcion', className: "desktop"},
                {data: 'estado.ESD_Nombre', name: 'Estado', className: "all"},
                {
                    defaultContent:
                        '@can('ELIMINAR_FACULTADES')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                        '@can('MODIFICAR_FACULTADES')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan',
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
            ];
            routeDatatable = "{{ route('admin.facultades.data') }}";
            table = $('#facultades_table_ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": routeDatatable,
                "columns": data,
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
                }
            });
            $(formCreate).parsley({
                trigger: 'change',
                successClass: "has-success",
                errorClass: "has-error",
                classHandler: function (el) {
                    return el.$element.closest('.form-group');
                },
                errorsWrapper: '<p class="help-block help-block-error"></p>',
                errorTemplate: '<span></span>',
            });
            $(document).on('submit', '#form_facultades', function (e) {
                e.preventDefault();
                let route = formCreate.attr('action');
                let method = formCreate.attr('method');
                let data = formCreate.serialize();
                if ($('#accion').hasClass('modificar')) {
                    route = '{{ url('admin/facultades') }}' + '/' + $('#PK_FCD_Id').val();
                    method = "PUT";
                }
                $.ajax({
                    url: route,
                    type: method,
                    data: data,
                    dataType: 'json',
                    success: function (response, NULL, jqXHR) {
                        $(formCreate)[0].reset();
                        $(formCreate).parsley().reset();
                        $('#modal_facultad').modal('hide');
                        new PNotify({
                            title: response.title,
                            text: response.msg,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        table.ajax.reload();
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
                });
            });
            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ url('admin/facultades') }}' + '/' + dataTable.PK_FCD_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_FCD_Id, route);
            });
            table.on('click', '.edit', function (e) {
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                $('#FCD_Nombre').val(dataTable.FCD_Nombre);
                $('#FCD_Descripcion').val(dataTable.FCD_Descripcion);
                $('#PK_FCD_Id').val(dataTable.PK_FCD_Id);
                $("#estado").val(dataTable.estado.PK_ESD_Id).change();
                $('#modal_facultad').modal('show');
                $('.modal-title').text("Modificar Facultad");
                $('#accion').val("Modificar");
                $('#accion').addClass('modificar');
            });
        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "La facultad sera eliminada permanentemente!",
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
                                swal('Oops...', 'Algo salio mal !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }
    </script>

@endpush