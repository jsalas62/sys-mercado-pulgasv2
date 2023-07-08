<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Usuario</th>    
            <th>Puja</th>               
            <th>Fecha Puja</th>                               
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
            @if(count($pujas) > 0)

                @php($i=1)                 
                @foreach($pujas as $key => $puj)
                <?php $parameter=Hashids::encode($puj->puja_id);?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $puj->usuario }}</td>
                        <td class="fw-bold">{{ $puj->puja }}</td>
                        <td class="font-weight-bold">{{ $puj->created_at }}</td>
                        @if($puj->estado==1)
                            <td><span class="badge rounded-pill bg-secondary">Pendiente</span></td>
                        @endif
                        @if($puj->estado==3)
                            <td><span class="badge rounded-pill bg-success">Ganada</span></td>
                        @endif
                        @if($puj->estado==2)
                            <td><span class="badge rounded-pill bg-danger">Pérdida</span></td>
                        @endif
                        @if($puj->estado==4)
                            <td><span class="badge rounded-pill bg-info">En Proceso</span></td>
                        @endif
                        @if($puj->estado==5)
                            <td><span class="badge rounded-pill bg-primary">Verificada</span></td>
                        @endif
                        @if($puj->estado==6)
                            <td><span class="badge rounded-pill bg-warning">Rechazada</span></td>
                        @endif
                        @if($puj->estado==7)
                            <td><span class="badge rounded-pill bg-recepcion">Recepcionado</span></td>
                        @endif
                   
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="5">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>

    {{ $pujas->onEachSide(1)->links('users.partials.my-paginate') }}


</div>
