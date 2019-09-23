{{-- <h4> <b>Proxima Fecha de Corte: </b></h4> --}}
<br>
    <div class="item form-group">
        {!! Form::label('FCO_Fecha','Proxima Fecha de Corte:', ['class'=>'control-label col-md-2 col-sm-2 col-xs-12']) !!}
        <div class="col-md-5 col-sm-6 col-xs-12">
            {!! Form::text('FCO_Fecha',$fechacorte->FCO_Fecha,
            [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
            'readonly'=>'readonly'
            ] ) !!}
        </div>
        <div class="actions">
            <a id="ver_fechascorte" href="#" class="btn btn-success" data-toggle="modal" data-target="#modal_fechascorte">
                <i class="fa fa-check"></i> Ver Todas las Fechas</a>
        </div>
    </div>
<br>
<hr size="10" width="100%" />
<br>
        
    <!-- Modal-->
        <div class="modal fade" id="modal_fechascorte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_titulo">Fechas de Corte</h4>
                    </div>
                    <div class="modal-body">

                    @foreach($fechascorte as $feco)
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {!! Form::text('FCO_FechaC',$feco->FCO_Fecha,
                                    [ 'class' => 'form-control col-md-2 col-sm-6 col-xs-6', 
                                      'readonly'=>'readonly'
                                ] ) !!}
                            </div>
                        </div>
                        @if($feco->FCO_Fecha == $fechahoy)
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <span class='label label-sm label-warning'>Se cumple hoy</span>
                            </div>
                        @endif
                        @if($feco->FCO_Fecha < $fechahoy)
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <span class='label label-sm label-danger'>Termino</span>
                            </div>
                        @endif
                        @if($feco->FCO_Fecha > $fechahoy)
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <span class='label label-sm label-success'>Por venir</span>
                            </div>
                        @endif
                        {{-- class='label label-sm label-danger'
                             class='label label-sm label-warning'
                             class='label label-sm label-info'
                             class='label label-sm label-success'
                         --}}
                        <br>
                        <br>
                    @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--Fin Modal -->
