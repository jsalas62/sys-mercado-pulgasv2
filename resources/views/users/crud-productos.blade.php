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

        <h3 class="page-title">
            {{ isset($producto) ? 'FORMULARIO DE ACTUALIZACIÓN DE PRODUCTO' : 'FORMULARIO DE REGISTRO DE PRODUCTO' }}
        </h3>

    </div>

    <div class="row px-4 mt-3">

        <div class="col-12">

            <div class="card">
                    
                <form method="POST" action="{{ url('user/productos') }}" enctype="multipart/form-data" id="formProducto">

                    @csrf

                    <div class="card-body px-5">

                        <h3 class="card-title">Datos del producto</h3>

                        <div class="form-group row mt-5">

                            <div class="col-7">
                                <input type="hidden" name="hddproducto_id" id="hddproducto_id" value="{{ isset($producto_id) ? $producto_id : '' }}">
                                <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Producto:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="nombreProducto"  name="nombreProducto" placeholder="Ingrese el Nombre del Producto.." value="{{ isset($producto) ? $producto->producto : '' }}">
                            </div>

                            <div class="col-lg-5 col-md-12">
                                <label><b><span style="color:#AB0505;">(*)</span> Categoría:</b></label>
                                <select class="form-control ml-2 selectpicker form-custom-input" name="categoriaProducto" id="categoriaProducto" data-live-search="true">
                                    <option value="0">--Seleccione--</option>
                                    @isset($categorias)
                                        @foreach ($categorias as $ct)
                                            @php $selected = '' @endphp
                                            @isset($producto)
                                                @if($ct['categoria_id'] == $producto->categoria_id):
                                                    @php $selected = 'selected' @endphp
                                                @endif
                                            @endisset
                                            <option value="{{$ct['categoria_id']}}" {{$selected}}>{{$ct['categoria']}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-12">
                                <label for="txtDescripcionProducto"><b>&nbsp;&nbsp;Descripción del Producto:</b></label>
                                <textarea class="form-control ml-2 form-custom-input" name="txtDescripcionProducto" id="txtDescripcionProducto" cols="20" rows="7" placeholder="Ingrese la Descripción..">
                                    {{isset($producto) ? $producto->descripcion_producto: ''}}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-12">
                                <label for="imgProducto"><b>&nbsp;&nbsp;Imagen:</b></label>
                                <input type="file" name="imgProducto" id="imgProducto" class="form-control">
                                @if(isset($producto) && $producto->imagen != "")
                                    <input type="hidden" name="idImgProducto" id="idImgProducto" value="{{$producto->imagen}}">
                                @endif
                            </div>
                        
                        </div>

                        <div  id="imgProducto_preview" class="form-group row mt-4">

                            @if(isset($producto) && $producto->imagen != "")
                                <div class="img-div col-md-3 col-6" id="imgprincipal-div{{$producto->producto_id}}">
                                    <img src="{{URL::asset($producto->imagen)}}" class="img-fluid image img-thumbnail" title="{{$producto->producto}}">
                                    <div class="middle">
                                        <button type="button" id="imagen-action-icon" value="imgprincipal-div{{$producto->producto_id}}" class="btn btn-danger" name="{{$producto->producto}}" temporal="0" producto_id='{{$producto->producto_id}}'>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-info" download href="{{URL::asset($producto->imagen)}}"><i class="fas fa-download"></i></a>
                                    </div>
                                    <input value="{{$producto->imagen}}|*|2023|*|0" name="imgproducto" type="hidden">
                                </div> 
                            @endif
                    
                        </div>
                
                        <div class="form-group row mt-4 px-2">
                            <div class="col-12">
                                <label for="chkEstadoProducto"><b>&nbsp;&nbsp;Estado:<b></label>
                                <div class="custom-control custom-checkbox ml-2">
                                    <input type="checkbox" class="custom-control-input" name="chkEstadoProducto" id="chkEstadoProducto" {{isset($producto) && $producto->estado == 1 ? 'checked':''}}>  
                                    <label class="custom-control-label" for="chkEstadoProducto">Activo</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer mt-4 mb-4">
                        <div class="form-group">

                            <p class="help-block font-weight-bold"><span style="color:#AB0505;">Nota: (*) Campos Obligatorios</span></p> 
                            <a class="btn btn-danger btn-icon-split" href="{{ url('/user/productos') }}"> <span class="icon text-white-50"><img src="{{ url('admin_assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                            <button type="submit" class="btn btn-dark btn-icon-split" id="guardarProducto"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                                                
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>


</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'txtDescripcionProducto' );
    CKEDITOR.config.allowedContent = true;
</script>
<script src="{{ asset('assets/js/productos.js') }}"></script>

@endsection