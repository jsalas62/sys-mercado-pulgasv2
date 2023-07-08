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
                <label for="estadoPujaBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoPujaBuscar" id="estadoPujaBuscar" class="form-control form-custom-input">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Pendiente</option>
                    <option value="3">Ganada</option>
                    <option value="2">Pérdida</option>
                    <option value="4">En proceso</option>
                    <option value="5">Verificado</option>
                    <option value="6">Rechazado</option>
                    <option value="7">Recepcionado</option>
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
                        Listado de Pujas
                    </h4>
                    <section class="pujas">
                        @if(isset($pujas) && count($pujas) > 0)
                            @include('users.data.pujas-data')
                        
                        @else 
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
                                        <tr>
                                            <td align="center" colspan="8">No se encontraron registros</td>
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
                                <td><img src="{{ url('admin_assets/images/eye1.png') }}" alt="Ver Producto" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Ver Producto</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/closed.png') }}" alt="Cerrar Subasta" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Cerrar Subasta</td>
                            </tr>

                            <tr>
                                <td><img src="{{ url('admin_assets/images/comprobante.png') }}" alt="Visualizar Comprobante" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Visualizar Comprobante</td>
                            </tr>

                            <tr>
                                <td><img src="{{ url('admin_assets/images/transport.png') }}" alt="Confirmar Recepción" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Confirmar Recepción</td>
                            </tr>

                            <tr>
                                <td><img src="{{ url('admin_assets/images/data-subastador.png') }}" alt="Ver Datos del Subastador" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Ver datos del Subastador</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

    <!--Bootstrap modal -->
    <div class="modal fade" id="ModalComprobante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document" style="margin-top:20px;">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalComprobanteLabel">
                        Comprobante de Pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalComprobante()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body with image -->
                <div class="modal-body">
                    <img id="imgComprobante" src="" width="450px" height="450px" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCerrarCategoria" data-bs-dismiss="modal" onclick="limpiarModalComprobante()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                </div>

            </div>
        </div>
    </div>

    <!--Bootstrap modal -->
    <div class="modal fade" id="ModalSubastadorData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document" style="margin-top:20px;">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalTitleData">
                       
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="LimpiarSubastadorModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body with image -->
                <div class="modal-body">
                    <div class="input-group">
                        <span class="fw-bold">Nombre:</span>&nbsp;&nbsp;
                        <label for=""id="lblNSubastador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Apellidos:</span>&nbsp;&nbsp;
                        <label for=""id="lblASubastador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Email:</span>&nbsp;&nbsp;
                        <label for=""id="lblESubastador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Teléfono:</span>&nbsp;&nbsp;
                        <label for=""id="lblTSubastador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Dirección:</span>&nbsp;&nbsp;
                        <label for=""id="lblDSubastador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Usuario:</span>&nbsp;&nbsp;
                        <label for=""id="lblUSubastador"></label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCloseModalDataSubatador" data-bs-dismiss="modal" onclick="LimpiarSubastadorModal()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')

<script src="{{ asset('assets/js/pujas.js') }}"></script>

@endsection