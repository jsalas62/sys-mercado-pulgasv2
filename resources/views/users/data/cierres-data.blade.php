<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Subastador</th>
                <th>Ganador</th>
                <th>Producto</th>
                <th>Puja</th>    
                <th>Comisión</th>             
                <th>Fecha Puja</th>
                <th>Modo</th>                                          
                <th>Pago</th>
                <th>Estado de Pago</th>
                <th>Estado de Entrega</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($cierres) > 0)

                @php($i=1)                 
                @foreach($cierres as $key => $cie)
                <?php $parameter=Hashids::encode($cie->cierre_subasta_id);
                        $subastadorId = Hashids::encode($cie->subastador_id);
                        $ganadorId = Hashids::encode($cie->ganador_id);
                ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $cie->subastador }}</td>
                        <td>{{ $cie->ganador }}</td>
                        <td>{{ $cie->producto }}</td>
                        <td>{{ $cie->puja }}</td>
                        <td>{{ number_format($cie->comision,2,".","") }}</td>
                        <td>{!! \Carbon\Carbon::parse($cie->created_at)->format('d/m/Y H:i:s') !!}</td>
                        <td>{{ $cie->modalidad }}</td>
                        <td>{{ $cie->modalidad_pago }}</td>
                        @if($cie->estado_pago == 1)
                            <td><span class="badge rounded-pill bg-secondary">Pendiente</span></td>
                        @endif

                        @if($cie->estado_pago == 2)
                            <td><span class="badge rounded-pill bg-success">Aprobado</span></td>
                        @endif

                        @if($cie->estado_pago == 3)
                            <td><span class="badge rounded-pill bg-danger">Rechazado</span></td>
                        @endif

                        @if($cie->estado_entrega == 1)
                            <td><span class="badge rounded-pill bg-secondary">En espera</span></td>
                        @endif
                        @if($cie->estado_entrega == 2)
                            <td><span class="badge rounded-pill bg-info">Enviado</span></td>
                        @endif
                        @if($cie->estado_entrega == 3)
                            <td><span class="badge rounded-pill bg-primary">Entregado</span></td>
                        @endif
                        @if($cie->estado_entrega == 4)
                            <td><span class="badge rounded-pill bg-danger">Rechazado</span></td>
                        @endif
                        <td>
                            <div class="btn-group gap-2" role="group">
                                @can('admin.cierres.ver_comprobante')
                                    <img src="{{ url('admin_assets/images/comprobante.png') }}" onclick="showComprobante(<?php echo "'".asset('assets/images/comprobantes/'.$cie->imagen_comprobante)."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Visualizar comprobante" alt="Visualizar comprobante"> 
                                @endcan

                                @if($cie->estado_pago==1)
                                    @can('admin.cierres.aprobar')
                                    <img src="{{ url('admin_assets/images/check.png') }}" onclick="aprobarCierre(<?php echo "'".$parameter."'"; ?>)" title="Aprobar Cierre" style="cursor: pointer; height:24px; width:24px;">
                                    @endcan

                                    @can('admin.cierres.rechazar')
                                    <img src="{{ url('admin_assets/images/block.png') }}" onclick="rechazarCierre(<?php echo "'".$parameter."'"; ?>)" title="Rechazar Cierre" style="cursor: pointer; height:24px; width:24px;">
                                    @endcan
                                @endif

                                @if($cie->estado_entrega == 2)
                                    @can('admin.cierres.confirmar_recepcion')
                                        <img src="{{ url('admin_assets/images/transport.png') }}" onclick="ConfirmarRecepcion(<?php echo "'".$parameter."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Confirmar Recepción" alt="Confirmar Recepción"> 
                                    @endcan
                                @endif
                                
                                @can('admin.cierres.datosSubastador')
                                    <img src="{{ url('admin_assets/images/data-subastador.png') }}" onclick="mostrarDataSubastador(<?php echo "'".$subastadorId."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Ver Datos del Subastador" alt="Ver Datos del Subastador"> 
                                @endcan
                                
                                @can('admin.cierres.datosGanador')
                                    <img src="{{ url('admin_assets/images/data-ganador.png') }}" onclick="mostrarDataGanador(<?php echo "'".$ganadorId."'"; ?>)" style="cursor: pointer; height:24px; width:24px;" title="Ver Datos del Ganador" alt="Ver Datos del Ganador"> 
                                @endcan
                            </div>
                        </td>

                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="12">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>

    {{ $cierres->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
