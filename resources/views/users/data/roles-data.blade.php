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
                            <td><span class="badge rounded-pill bg-success">Activo</span></td>
                        @else 
                        <td><span class="badge rounded-pill bg-danger">Inactivo</span></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                                    @can('admin.roles.actualizar')
                                    <a href="{{ route('user.roles.edit',$parameter) }}"><img src="{{ url('admin_assets/images/edit.png') }}" title="Editar Usuario" style="cursor: pointer; height:24px; width:24px;"></a>
                                    @endcan
                                    
                                    @can('admin.roles.borrar')
                                    <img src="{{ url('admin_assets/images/delete3.png') }}" onclick="eliminarRol(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Banner" style="cursor: pointer; height:24px; width:24px;">
                                    @endcan
                                @if($rol->estado!=0)
                                    @can('admin.roles.desactivar')
                                    <img src="{{ url('admin_assets/images/off.png') }}" onclick="desactivarRol(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Banner" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                                    @endcan
                                @else 
                                    @can('admin.roles.activar')
                                    <img src="{{ url('admin_assets/images/on.png') }}" onclick="activarRol(<?php echo "'".$parameter."'"; ?>)" title="Activar Banner" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                                    @endcan
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

    {{ $roles->onEachSide(1)->links('users.partials.my-paginate') }}


</div>