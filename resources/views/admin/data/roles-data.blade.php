<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($roles) > 0)

                @php($i=1)                 
                @foreach($roles as $key => $rol)
                <?php $parameter=Hashids::encode($rol->id);?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="text-muted">{{ $rol->name }}</td>
                        @if($rol->estado!=0)
                            <td><label class="badge badge-success badge-pill">Activo</label></td>
                        @else 
                           <td><label class="badge badge-danger badge-pill">Inactivo</label></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                             
                                    <a href="{{ route('admin.roles.edit',$parameter) }}"><img src="{{ url('admin_assets/images/edit.png') }}" title="Editar Usuario" style="cursor: pointer; height:24px; width:24px;"></a>
                             
                                    <img src="{{ url('admin_assets/images/delete3.png') }}" onclick="eliminarRol(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Banner" style="cursor: pointer; height:24px; width:24px;">
             
                                @if($rol->estado!=0)
 
                                    <img src="{{ url('admin_assets/images/off.png') }}" onclick="desactivarRol(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Banner" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                    
                                @else 
            
                                    <img src="{{ url('admin_assets/images/on.png') }}" onclick="activarRol(<?php echo "'".$parameter."'"; ?>)" title="Activar Banner" style="cursor: pointer; height:24px; width:24px;">&nbsp;
          
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

    {{ $roles->onEachSide(1)->links('admin.partials.my-paginate') }}


</div>