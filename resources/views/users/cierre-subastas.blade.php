@extends('temlate')

@section('content')

<div class="container">

    <div class="row mt-3">

        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{url('/')}}">
                <img class="img-fluid" src="{{asset('assets/images/logo22.jpg')}}" width="358">
            </a>
            <a href="{{url('/')}}" class="login-back-link blue">
                <i class="fas fa-arrow-left"></i>
                <span>Regresar a la tienda</span>
            </a>
        </div>

    </div>

      
</div>

@include('front-partials.navbar-account')

<div class="container-fluid container-xxl">

    <div class="row mt-4 px-4">
       
        <div class="col-xl-5 col-md-5 col-sm-12">
           <div class="form-group">
               <label for="estadoCierreBuscar" style="font-size:14px;">Estado:</label>
               <select name="estadoCierreBuscar" id="estadoCierreBuscar" class="form-control form-custom-input">
                   <option value="_all_">--Seleccione--</option>
                   <option value="1">Pendiente</option>
                   <option value="3">Aprobado</option>
                   <option value="2">Rechazado</option>
               </select>
           </div>
       </div>
       
   </div>

   <div class="row mt-4">

        <div class="col-12 grid-margin">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                    <i class="fas fa-cubes"></i>
                        Listado de Cierres
                    </h4>
                    <section class="cierres">
                        @if(isset($cierres) && count($cierres) > 0)
                            @include('users.data.cierres-data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subastador</th>
                                        <th>Ganador</th>
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
                                        <tr>
                                            <td align="center" colspan="11">No se encontraron registros</td>
                                        </tr>
                                
                                    </tbody>
                                </table>
                            </div>
                            
                        @endif
                    </section>
                </div>  

            </div>

        </div>

    </div>

    <div class="row justify-content-center mt-5 mb-4">
        <div class="col-sm-5 align-self-center text-center">
            <div class="card">
                <div class="card-body">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Leyenda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/comprobante.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Visualizar Comprobante</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/check.png') }}" alt="Editar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Aprobar Cierre</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/block.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Rechazar Cierre</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/data-subastador.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Datos Subastador</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/data-ganador.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Datos Ganador</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/transport.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Confirmar Recepción</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


    <!--Bootstrap modal -->
    <div class="modal fade" id="ModalImagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document" style="margin-top:20px;">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalImagenLabel">
                        Comprobante de Pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarShowComprobante()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body with image -->
                <div class="modal-body">
                    <img id="imgshow" src="" width="450px" height="450px" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCloseModalImagen" data-bs-dismiss="modal" onclick="limpiarShowComprobante()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                </div>

            </div>
        </div>
    </div>

     <!--Bootstrap modal -->
     <div class="modal fade" id="ModalDataSubastador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document" style="margin-top:20px;">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalDataTitle">
                       
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalSubastador()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body with image -->
                <div class="modal-body">
                    <div class="input-group">
                        <span class="fw-bold">Nombre:</span>&nbsp;&nbsp;
                        <label for=""id="lblNombre"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Apellidos:</span>&nbsp;&nbsp;
                        <label for=""id="lblApellidos"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Email:</span>&nbsp;&nbsp;
                        <label for=""id="lblEmail"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Teléfono:</span>&nbsp;&nbsp;
                        <label for=""id="lblTeléfono"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Dirección:</span>&nbsp;&nbsp;
                        <label for=""id="lblDirección"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Usuario:</span>&nbsp;&nbsp;
                        <label for=""id="lblUsuario"></label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCloseModalSubatador" data-bs-dismiss="modal" onclick="limpiarModalSubastador()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/cierres.js') }}"></script>

@endsection