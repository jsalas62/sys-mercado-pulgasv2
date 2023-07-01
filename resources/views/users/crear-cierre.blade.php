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

    <div class="row px-4 mt-3">

        <div class="col-12">

            <div class="card">

                <form method="POST" action="{{ url('user/productos') }}" enctype="multipart/form-data" id="formProducto">

                    @csrf   
                    
                    <div class="card-body px-5">

                        <h3 class="card-title">Cierre de Subasta</h3>
                        <div class="form-group row mt-5">
                            <div class="col-md-4 col-12">
                                <input type="hidden" name="hddpuja_id" id="hddpuja_id" value="{{$pujaid}}">
                                <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Modo de Entrega:</b></label>
                                <select class="form-control ml-2 selectpicker form-custom-input" name="modoEntrega" id="modoEntrega" data-live-search="true">
                                    <option value="0">--Seleccione--</option>
                                    @isset($listadoModos)
                                        @foreach ($listadoModos as $lm)
                                            <option value="{{$lm->modo_id}}">{{$lm->modalidad}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-4 col-12">
                                <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Modalidad de Pago:</b></label>
                                <select class="form-control ml-2 selectpicker form-custom-input" name="modoEntrega" id="modoEntrega" data-live-search="true">
                                    <option value="">--Seleccione--</option>
                                    <option value="YAPE">Yape</option>
                                    <option value="PLIN">PLIN</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12">
                              
                                <label for="nombreProducto"><b> Comisión:</b></label>
                                <input type="number" class="form-control form-custom-input ml-2" id="comisionCierre"  name="comisionCierre" value="0.00">
                            </div>
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-12">
                                <label for="imgcomprobante"><b>&nbsp;&nbsp;Comprobante:</b></label>
                                <input type="file" name="imgcomprobante" id="imgcomprobante" class="form-control form-custom-input">
                               
                            </div>
                        </div>

                    </div>

                    <div class="card-footer mt-4">
                        <div class="form-group">

                            <p class="help-block font-weight-bold"><span style="color:#AB0505;">Nota: (*) Campos Obligatorios</span></p> 
                            <a class="btn btn-danger btn-icon-split" href="{{ url('/user/pujas') }}"> <span class="icon text-white-50"><img src="{{ url('admin_assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                            <button type="submit" class="btn btn-dark btn-icon-split" id="guardarCierre"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                                                
                        </div>
                    </div>
                    
                </form>

            </div>

        </div>
    
    </div>

</div>

</div>