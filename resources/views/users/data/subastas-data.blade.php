<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>   
            <th>Precio Mínimo</th>     
            <th>Usuario</th>                                          
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @if(count($subastas) > 0)

                @php($i=1)                 
                @foreach($subastas as $key => $subas)
                <?php $parameter=Hashids::encode($subas->subasta_id);?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">
                            <img src="{{URL::asset($subas->imagen)}}" class="img-fluid" width="60" alt="Foto Usuario">
                            {{ $subas->producto }}
                        </td>
                        <td class="text-muted">{{ $subas->tiempo_inicio }}</td>
                        <td class="text-muted">{{ $subas->tiempo_fin }}</td>
                        <td class="text-muted">{{ $subas->precio_min }}</td>
                        <td class="text-muted">{{ $subas->usuario }}</td>
                        @if($subas->estado==1)
                            <td><span class="badge rounded-pill bg-success">Disponible</span></td>
                        @else 
                           <td><span class="badge rounded-pill bg-danger">Finalizada</span></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
              
                                <img src="{{ url('admin_assets/images/edit.png') }}" onclick="mostrarSubasta(<?php echo "'".$parameter."'"; ?>)" title="Editar Subasta" style="cursor: pointer; height:24px; width:24px;">

                                
                                <img src="{{ url('admin_assets/images/delete3.png') }}" onclick="eliminarSubasta(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Subasta" style="cursor: pointer; height:24px; width:24px;">

                                @if($subas->estado==1)
                                    <img src="{{ url('admin_assets/images/time.png') }}" onclick="terminarSubasta(<?php echo "'".$parameter."'"; ?>)" title="Terminar Subasta" style="cursor: pointer; height:24px; width:24px;">
                                @endif

                                @if($subas->pujas > 0)
                                <img src="{{ url('admin_assets/images/pujas.png') }}" onclick="verPujas(<?php echo "'".$parameter."'"; ?>)" title="Ver Pujas" style="cursor: pointer; height:24px; width:24px; margin-left:2px;">
                                @endif
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

    {{ $subastas->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
