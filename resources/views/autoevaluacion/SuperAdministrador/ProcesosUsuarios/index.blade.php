{{-- Titulo de la pagina --}}
@section('title', 'Usuarios')


{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel') @slot('title', 'Asignar Usuarios A Proceso '. $proceso )
    {{-- @can('ASIGNAR_USUARIOS_PROCESOS') --}}
    <div class="col-md-12">
        <div class="actions">
            <a id="asignar_usuarios" href="#" class="btn btn-info">
                <i class="fa fa-plus"></i> Asignar usuarios</a></div>
    </div>
    <br>
    <br>
    <br>

    <div class="col-md-12">
        @component('admin.components.datatable', ['id' => 'usuario-table-ajax']) @slot('columns', [
        'id' ,'<input type="checkbox" id="seleccionar_todo" name="seleccionar_todo" value="">'=> ['style' => 'width:25px;'], 'Nombre', 'Apellido']) @endcomponent

    </div>
    {{-- @endcan --}}
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
            $("#seleccionar_todo").change(function () {
                if (this.checked) {
                    $('.ids_usuarios').prop('checked', true);
                }
                else {
                    $('.ids_usuarios').prop('checked', false);
                }
            });
            table = $('#usuario-table-ajax').DataTable({
                processing: true,
                serverSide: false,
                stateSave: true,
                keys: true,
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "ajax": "{{ route('admin.procesos_usuarios.data', request()->route()->parameter('id')) }}",
                "columns": [
                    {data: 'id', name: 'id', "visible": false},
                    {data: 'seleccion', name: 'Seleccionar', className: "all"},
                    {data: 'name', name: 'Nombre', className: "all"},
                    {data: 'lastname', name: 'Apellido', className: "min-tablet-l"},
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
                }
            });
            $("#asignar_usuarios").click(
                function (event) {
                    event.preventDefault();
                    var id = [];
                    $('.ids_usuarios:checked').each(function () {
                        id.push($(this).val());
                    });
                    $.ajax({
                        url: "{{ route('admin.procesos_usuarios.asignar', request()->route()->parameter('id')) }}",
                        type: 'POST',
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            usuarios: id
                        },
                        dataType: 'json',
                        success: function (response, NULL, jqXHR) {
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
                    });
                }
            );

        });
    </script>

@endpush