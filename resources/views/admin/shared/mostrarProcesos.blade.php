<!-- Modal Procesos-->
<div class="modal fade" id="modal_mostrar_procesos" tabindex="-1" role="dialog" aria-labelledby="modal_titulo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_titulo">Seleccionar proceso</h4>
            </div>
            <div class="modal-body">

                {!! Form::open([ 'route' => 'admin.mostrar_procesos.seleccionar_proceso', 'method' => 'POST', 'id' => 'form_mostrar_proceso',
                'class' => 'form-horizontal form-label-left', 'novalidate' ])!!}

                <div class="form-group">
                    {!! Form::label('PK_PCS_Id', 'Proceso', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {!! Form::select('PK_PCS_Id', isset($procesos_usuario)?$procesos_usuario:[], old('PK_PCS_Id'),
                        ['class' => 'select2 form-control', 
                        'required' => '', 
                        'id' => 'procesos_usuario']) !!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> {!! Form::submit( 'Seleccionar
                proceso', ['class' => 'btn btn-success']) !!}

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!--FIN Modal Procesos-->