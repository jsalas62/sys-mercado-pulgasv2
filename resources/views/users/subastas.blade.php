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

    <div class="row mt-5 px-4">
       
        <div class="col-xl-7 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtBuscarCategoria" style="font-size:14px;">Producto: </label>
                <select class="form-control ml-2 selectpicker form-custom-input" name="buscarProductoSubasta" id="buscarProductoSubasta" data-live-search="true">
                    <option value="_all_">--Seleccione--</option>
                    @isset($productos)
                        @foreach ($productos as $prods)
                            <option value="{{$prods['producto_id']}}">{{$prods['producto']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoCategoriaBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoSubastaBuscar" id="estadoSubastaBuscar" class="form-control form-custom-input">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Disponible</option>
                    <option value="2">Finalizada</option>
                </select>
            </div>
        </div>
        
    </div>

    @can('admin.subasta.crear')

    <div class="row px-4">
        <div class="col-xl-12 col-md-12 col-sm-12 d-flex justify-content-end mt-4">

            <div class="form-group mr-20-sm">
                <button type="button" class="btn btn-sm btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalSubasta"><img src="{{ url('admin_assets/images/add2.png') }}" alt="agregar" width="25px"> Agregar Subasta</button>
            </div>

        </div>
    </div>

    @endcan

    <div class="row mt-3">

        <div class="col-12 grid-margin">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                    <i class="fas fa-cubes"></i>
                        Listado de Subastas
                    </h4>
                    <section class="subastas">
                        @if(isset($subastas) && count($subastas) > 0)
                            
                            @include('users.data.subastas-data')
                        
                        @else 
                        
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
                                <td><img src="{{ url('admin_assets/images/edit.png') }}" alt="Editar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Editar Subasta</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/delete3.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Eliminar Subasta</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/time.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Terminar Subasta</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/pujas.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Ver pujas</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/data-ganador.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Ver Datos del Ganador</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Agregar -->
<div class="modal fade" id="ModalSubasta" tabindex="-1" aria-labelledby="ModalSubastalabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" >
    <div class="modal-dialog modal-lg" role="document" style="margin-top:20px;">
        <div class="modal-content">

            <form role="form" method="post" return="false" id="formSubasta" name="formSubasta">

                <div class="modal-header" style="background-color:#ac56fa">
                    <h5 class="modal-title font-weight-bold text-primary" id="tituloModalSubasta" style="color:white !important">AGREGAR SUBASTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalSubasta()"></button>
                </div>

                <div class="modal-body">
                
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card mb-4">

                                <div class="card-body">

                                    <div id="error-div"></div>

                                    <div class="form-group mt-2">
                                        <input type="hidden" name="hddsubasta_id" id="hddsubasta_id" value="">
                                        <label><b><span style="color:#AB0505;">(*)</span> Producto:</b></label>
                                        <select class="form-control ml-2 selectpicker form-custom-input" name="cboProductoId" id="cboProductoId" data-live-search="true">
                                            <option value="">--Seleccione--</option>
                                            @isset($productos)
                                                @foreach ($productos as $prods)
                                                    <option value="{{$prods['producto_id']}}">{{$prods['producto']}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="txtPrecioMinimo"><b>&nbsp;&nbsp;Precio Mínimo:</b></label>
                                        <input type="number" class="form-control form-custom-input ml-2" id="txtPrecioMinimo"  name="txtPrecioMinimo" placeholder="Ingrese el Precio del Producto.." min="0" value="{{ isset($producto) ? $producto->precio : '0.00' }}" step="0.01" >
                                    </div>
                                    
                                    <div class="form-group mt-3 row">

                                        <div class="col-md-6 col-12">
                                            <label for="dateFechaInicio"><b>Fecha Inicio:</b></label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control form-custom-input" id="dateFechaInicio" name="dateFechaInicio" value="">
                                              
                                            </div> 
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <label for="dateFechaFin"><b>Fecha Fin:</b></label>
                                            <div class="input-group">
                                                <input type="datetime-local" class="form-control form-custom-input" id="dateFechaFin" name="dateFechaFin" value="01/01/2014">
                                               
                                            </div> 
                                        </div>
                           
                                    </div>
                            
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-dark btn-pri" id="btnGuardarSubasta"> <img src="{{ url('admin_assets/images/save.png') }}" width="20px" height="20px"> GUARDAR</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarSubasta" data-bs-dismiss="modal" onclick="limpiarModalSubasta()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal Ver Pujas -->
<div class="modal fade" id="ModalVerPujas" tabindex="-1" aria-labelledby="ModalVerPujaslabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" >
    <div class="modal-dialog modal-lg" role="document" style="margin-top:20px;">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#ac56fa">
                <h5 class="modal-title font-weight-bold text-primary" id="tituloModalVerPujas" style="color:white !important">VER PUJAS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalVerPujas()"></button>
            </div>

            <div class="modal-body">
            
                <div class="row">

                    <div class="col-lg-12">

                        <div class="card mb-4">

                            <div class="card-body">

                                <section class="verPujasTbl">

                                </section>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCerrarVerPujas" data-bs-dismiss="modal" onclick="limpiarModalVerPujas()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
            </div>

        </div>
    </div>
</div>


  <!--Bootstrap modal -->
  <div class="modal fade" id="ModalGanadorData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document" style="margin-top:20px;">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalTitleDataGanador">
                       
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="LimpiarGanadorModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body with image -->
                <div class="modal-body">
                    <div class="input-group">
                        <span class="fw-bold">Nombre:</span>&nbsp;&nbsp;
                        <label for=""id="lblNGanador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Apellidos:</span>&nbsp;&nbsp;
                        <label for=""id="lblAGanador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Email:</span>&nbsp;&nbsp;
                        <label for=""id="lblEGanador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Teléfono:</span>&nbsp;&nbsp;
                        <label for=""id="lblTGanador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Dirección:</span>&nbsp;&nbsp;
                        <label for=""id="lblDGanador"></label>
                    </div>
                    <div class="input-group mt-2">
                        <span class="fw-bold">Usuario:</span>&nbsp;&nbsp;
                        <label for=""id="lblUGanador"></label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCloseModalDataGanador" data-bs-dismiss="modal" onclick="LimpiarGanadorModal()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')


<script src="{{ asset('assets/js/subastas.js') }}"></script>

@endsection