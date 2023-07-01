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
                <?php $parameter=Hashids::encode($puja->puja_id);?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">
                            <img src="{{URL::asset($puja->imagen)}}" class="img-fluid" width="60" alt="Foto Producto">
                        </td>
                        <td>  {{ $puja->producto }}</td>
                        <td class="text-muted">{{ $puja->puja }}</td>
                        <td class="text-muted">{{ $puja->created_at }}</td>
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
                        <td>
                            <div class="btn-group" role="group">
              
                                <a href="{{ url('producto/'.$puja['url']) }}"><img src="{{ url('admin_assets/images/eye1.png') }}" title="Ver producto" style="cursor: pointer; height:24px; width:24px;"></a>
                                @if($puja->estado==3)
                                <a href="{{ url('user/crear-cierre/'.$parameter) }}"><img src="{{ url('admin_assets/images/closed.png') }}" title="Completar Subasta" style="cursor: pointer; height:24px; width:24px;"></a>
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

    {{ $pujas->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
