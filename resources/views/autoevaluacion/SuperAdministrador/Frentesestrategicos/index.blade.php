{{-- Titulo de la pagina --}}
@section('title', 'Frente Estrategico')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content') @component('admin.components.panel')
    @slot('title', 'Frente Estrategico')
    <div class="col-md-12">
        @can('CREAR_FRENTE_ESTRATEGICO')
            <div class="actions">
                <a id="crear_ambitos" href="#" class="btn btn-info" data-toggle="modal" data-target="#modal_ambito">
                    <i class="fa fa-plus"></i> Agregar Ambitos</a></div>
    @endcan
    <!-- Modal-->
        <div class="modal fade" id="modal_ambito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_titulo">Crear Ambito</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::open([ 'route' => 'admin.ambito.store',
                        'method' => 'POST', 'id' => 'form_ambito', 'class' => 'form-horizontal
                            form-label-lef', 'novalidate' ])!!}
                        @include('autoevaluacion.SuperAdministrador.Ambito._form')

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        {!! Form::submit('Crear
                        Ambito', ['class' => 'btn btn-success', 'id' => 'accion']) !!}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--FIN Modal CREAR-->

    </div>
    @can('VER_AMBITOS')
        <br>
        <br>
        <br>
        <div class="col-md-12">
            @component('admin.components.datatable',
            ['id' => 'ambito_table_ajax'])
                @slot('columns', [ 'id', 'Nombre','Acciones' =>
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

            var formCreate = $('#form_ambito');
            $('#crear_ambitos').click(function () {
                $(formCreate)[0].reset();
                $('.modal-title').text("Crear Ambitos");
                $('#accion').val("Crear");
                $('#accion').removeClass('modificar')
            });
            var data, routeDatatable;
            data = [
                {data: 'PK_AMB_Id', name: 'id', "visible": false},
                {data: 'AMB_Nombre', name: 'Nombre', className: "min-table-p"},
                {
                    defaultContent:
                        '@can('ELIMINAR_AMBITOS')<a href="javascript:;" class="btn btn-simple btn-danger btn-sm remove" data-toggle="confirmation"><i class="fa fa-trash"></i></a>@endcan' +
                        '@can('MODIFICAR_AMBITOS')<a href="javascript:;" class="btn btn-simple btn-info btn-sm edit" data-toggle="confirmation"><i class="fa fa-pencil"></i></a>@endcan',
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
            routeDatatable = "{{ route('admin.ambito.data') }}";
            table = $('#ambito_table_ajax').DataTable({
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
            $(document).on('submit', '#form_ambito', function (e) {
                e.preventDefault();
                let route = formCreate.attr('action');
                let method = formCreate.attr('method');
                let data = formCreate.serialize();
                if ($('#accion').hasClass('modificar')) {
                    route = '{{ url('admin/ambito') }}' + '/' + $('#PK_AMB_Id').val();
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
                        $('#modal_ambito').modal('hide');
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
                var route = '{{ url('admin/ambito') }}' + '/' + dataTable.PK_AMB_Id;
                var type = 'DELETE';
                dataType: "JSON",
                    SwalDelete(dataTable.PK_AMB_Id, route);
            });
            table.on('click', '.edit', function (e) {
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                $('#AMB_Nombre').val(dataTable.AMB_Nombre);
                $('#PK_AMB_Id').val(dataTable.PK_AMB_Id);
                $('#modal_ambito').modal('show');
                $('.modal-title').text("Modificar ambito");
                $('#accion').val("Modificar");
                $('#accion').addClass('modificar');
            });
        });

        function SwalDelete(id, route) {
            swal({
                title: 'Esta seguro?',
                text: "Se eliminara el ambito permanentemente!",
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