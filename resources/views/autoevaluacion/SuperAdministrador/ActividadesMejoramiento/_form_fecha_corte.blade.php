{{-- <h4> <b>Proxima Fecha de Corte: </b></h4> --}}
@if($fechacorte != null)
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
@else
    <br>
        <div class="item form-group">
            {!! Form::label('FCO_Fecha','Proxima Fecha de Corte:', ['class'=>'control-label col-md-2 col-sm-2 col-xs-12']) !!}
            <div class="col-md-5 col-sm-6 col-xs-12">
                {!! Form::text('FCO_Fecha','EL PROCESO NO POSEE FECHAS DE CORTE' ,
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
@endif        
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
                        <div class="item form-group">
                            @foreach($fechascorte as $feco)
                                <br>
                                <div class="col-md-1 col-sm-6 col-xs-2">
                                </div>
                                <div >
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        {!! Form::text('FCO_FechaC',$feco->FCO_Fecha,
                                            [ 'class' => 'form-control col-md-2 col-sm-6 col-xs-6', 
                                              'readonly'=>'readonly'
                                        ] ) !!}
                                    </div>
                                </div>
                                @if($feco->FCO_Fecha == $fechahoy)
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <h4> <span class='label label-sm label-danger'><i class="fa fa-exclamation-triangle"></i>&nbsp&nbsp&nbspSe cumple hoy</span> </h4>
                                    </div>
                                @endif
                                @if($feco->FCO_Fecha < $fechahoy)
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <h4><span class='label label-sm label-success'><i class="fa fa-check"></i>&nbsp&nbsp&nbspFecha de Corte Cumplida</span> </h4>
                                        {{-- <a href="#" class="btn btn-success" ><i class="fa fa-check"></i> Fecha de Corte Cumplida</a> --}}
                                    </div>
                                @endif
                                @if($feco->FCO_Fecha > $fechahoy)
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <h4> <span class='label label-sm label-info'><i class="fa fa-circle-o"></i>&nbsp&nbsp&nbspFecha de Corte por cumplir</span> </h4>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--Fin Modal -->
