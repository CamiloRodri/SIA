 <!-- Modal-->
        <div class="modal fade" id="modal_agregar_evidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_titulo">Agregar Evidencia</h4>
                    </div>
                    <div class="modal-body">

                        {{-- {!! Form::open([ 'route' => 'admin.evidencia.store', 'method' => 'POST', 'id' => 'form_evidencia', 'class' => 'form-horizontal
                            form-label-lef', 'novalidate' ])!!} --}}
                            <br><br><br><br><br><br>
                        {{-- @include('autoevaluacion.SuperAdministrador.FechasdeCorte._form') --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        {!! Form::submit
                            ('Agregar', ['class' => 'btn btn-success', 'id' => 'accion']) !!}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--FIN Modal CREAR-->