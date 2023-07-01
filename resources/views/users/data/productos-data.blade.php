<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Categorias</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @if(count($productos) > 0)

                @php($i=1)                 
                @foreach($productos as $key => $pro)
                <?php $encryptagid=Hashids::encode($pro->producto_id);?>
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        @if($pro->imagen!= '')
                        <td><img src="{{URL::asset($pro->imagen)}}" class="img-fluid" alt="Imagen Producto" width="248"></td>
                        @else 
                        <td><img src="{{URL::asset('admin_assets/images/productos/producto.png')}}"  class="img-fluid" alt="Imagen Producto"></td>
                        @endif
                        <td class="font-weight-bold">{{$pro->producto}}</td>
                        <td>{{$pro->categoria}}</td>
                        <td class="text-muted">{{ Str::limit(strip_tags($pro->descripcion_producto),100)}}</td>
                        @if($pro->estado!=0)
                        <td><span class="badge rounded-pill bg-success">Activo</span></td>
                        @else 
                        <td><span class="badge rounded-pill bg-danger">Inactivo</span></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">

                                <a href="{{ route('user.productos.edit',$encryptagid) }}"><img src="{{ url('admin_assets/images/edit.png') }}" title="Editar Producto" style="cursor: pointer; height:24px; width:24px;"></a>

                                <img src="{{ url('admin_assets/images/delete3.png') }}" onclick="eliminarProducto(<?php echo "'".$encryptagid."'"; ?>)" title="Eliminar Producto" style="cursor: pointer; height:24px; width:24px;">
        
                                @if($pro->estado!=0)
                         
                                    <img src="{{ url('admin_assets/images/off.png') }}" onclick="desactivarProducto(<?php echo "'".$encryptagid."'"; ?>)" title="Desactivar Producto" style="cursor: pointer; height:24px; width:24px;">&nbsp;
        
                                @else 
              
                                    <img src="{{ url('admin_assets/images/on.png') }}" onclick="activarProducto(<?php echo "'".$encryptagid."'"; ?>)" title="Activar Producto" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                
                                @endif
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="7">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>
    
    {{ $productos->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
