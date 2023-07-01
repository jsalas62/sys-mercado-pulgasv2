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
                        @if($puj->estado == 1)
                            <td><span class="badge rounded-pill bg-secondary">En espera</span></td>
                        @endif
                        @if($puj->estado == 3)
                            <td><span class="badge rounded-pill bg-success">Ganada</span></td>
                        @endif
                        @if($puj->estado == 2)
                           <td><span class="badge rounded-pill bg-danger">Pérdida</span></td>
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
