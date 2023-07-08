<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Puja</th>               
            <th>Fecha Puja</th>
            <th>Usuario</th>                                          
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @if(count($pujas) > 0)

                @php($i=1)                 
                @foreach($pujas as $key => $puja)
                <?php $parameter=Hashids::encode($puja->puja_id);
                        $subastador_id = Hashids::encode($puja->subastador_id);
                ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">
                            <img src="{{URL::asset($puja->imagen)}}" class="img-fluid" width="60" alt="Foto Producto">
                        </td>
                        <td>  {{ $puja->producto }}</td>
                        <td class="text-muted">{{ $puja->puja }}</td>
                        <td class="text-muted">{!! \Carbon\Carbon::parse($puja->created_at)->format('d/m/Y H:i:s') !!}</td>
                        <td class="text-muted">{{ $puja->usuario }}</td>
                        @if($puja->estado==1)
                            <td><span class="badge rounded-pill bg-secondary">Pendiente</span></td>
                        @endif
                        @if($puja->estado==3)
                            <td><span class="badge rounded-pill bg-success">Ganada</span></td>
                        @endif
                        @if($puja->estado==2)
                            <td><span class="badge rounded-pill bg-danger">Pérdida</span></td>
                        @endif
                        @if($puja->estado==4)
                            <td><span class="badge rounded-pill bg-info">En Proceso</span></td>
                        @endif
                        @if($puja->estado==5)
                            <td><span class="badge rounded-pill bg-primary">Verificada</span></td>
                        @endif
                        @if($puja->estado==6)
                            <td><span class="badge rounded-pill bg-warning">Rechazada</span></td>
                        @endif
                        @if($puja->estado==7)
                            <td><span class="badge rounded-pill bg-recepcion">Recepcionado</span></td>
                        @endif
                        <td>
                            <div class="btn-group gap-2 d-flex align-items-center" role="group">
                                @can('admin.pujas.ver_producto')
                                    <a href="{{ url('producto/'.$puja['url']) }}"><img src="{{ url('admin_assets/images/eye1.png') }}" title="Ver producto" style="cursor: pointer; height:24px; width:24px;"></a>
                                @endcan
                                
                                @can('admin.pujas.crear_cierre')
                                    @if($puja->estado==3)
                                        <a href="{{ url('user/crear-cierre/'.$parameter) }}"><img src="{{ url('admin_assets/images/closed.png') }}" title="Completar Subasta" style="cursor: pointer; height:24px; width:24px;"></a>
                                    @endif
                                @endcan

                                @can('admin.pujas.ver_comprobante')
                                    @if($puja->estado==4 || $puja->estado==5 || $puja->estado==6 || $puja->estado==7) 
                                        <img src="{{ url('admin_assets/images/comprobante.png') }}" onclick="MostrarComprobante(<?php echo "'".asset('assets/images/comprobantes/'.$puja->comprobante)."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Visualizar comprobante" alt="Visualizar comprobante">  
                                    @endif
                                @endcan

                                @can('admin.pujas.datos_subastador')
                                    @if($puja->estado == 5 || $puja->estado == 7)
                                    <img src="{{ url('admin_assets/images/data-subastador.png') }}" onclick="showSubastador(<?php echo "'".$subastador_id."'"; ?>)" style="cursor: pointer; height:22px; width:22px;" title="Ver Datos del Ganador" alt="Ver Datos del Ganador"> 
                                    @endif
                                @endcan

                                @can('admin.pujas.confirmar_recepcion')
                                    @if($puja->estado==5)
                                        <img src="{{ url('admin_assets/images/transport.png') }}" onclick="confirmarRecepcionPuja(<?php echo "'".$parameter."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Confirmar Recepción" alt="Confirmar Recepción"> 
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="8">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>

    {{ $pujas->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
