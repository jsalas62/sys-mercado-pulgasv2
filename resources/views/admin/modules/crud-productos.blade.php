@extends('admin.master')

@section('title', 'Mantemiento Producto')

@section('content')

    <div class="content-wrapper">

        <div class="page-header row">

            <h3 class="page-title">
            {{ isset($producto) ? 'FORMULARIO DE ACTUALIZACIÓN DE PRODUCTO' : 'FORMULARIO DE REGISTRO DE PRODUCTO' }}
            </h3>

            <div class="template-demo mt-20">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom"">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="colorfont"> <i class="fas fa-fw fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin/productos') }}" class="colorfont"> <i class="fas fa-dolly-flatbed"></i> Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-dolly"></i> {{ isset($producto) ? 'Actualización de Producto':'Registro de Producto' }}</li>
                    </ol>
                </nav>
            </div>

        </div>

        <div class="row">

            <div class="col-12 grid-margin stretch-card">

                <div class="card">
                    
                    <form method="POST" action="{{ url('admin/productos') }}" enctype="multipart/form-data" id="formProducto">

                        @csrf

                        <div class="card-body">

                            <h3 class="card-title">Datos del producto</h3>

                            <div class="form-group row">

                                <div class="col-7">
                                    <input type="hidden" name="hddproducto_id" id="hddproducto_id" value="{{ isset($producto_id) ? $producto_id : '' }}">
                                    <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Producto:</b></label>
                                    <input type="text" class="form-control form-control-sm ml-2" id="nombreProducto"  name="nombreProducto" placeholder="Ingrese el Nombre del Producto.." value="{{ isset($producto) ? $producto->producto : '' }}">
                                </div>

                                <div class="col-lg-5 col-md-12">
                                    <label><b><span style="color:#AB0505;">(*)</span> Categoría:</b></label>
                                    <select class="form-control ml-2 selectpicker" name="categoriaProducto" id="categoriaProducto" data-live-search="true">
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

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="txtDescripcionProducto"><b>&nbsp;&nbsp;Descripción del Producto:</b></label>
                                    <textarea class="form-control ml-2" name="txtDescripcionProducto" id="txtDescripcionProducto" cols="20" rows="7" placeholder="Ingrese la Descripción..">
                                        {{isset($producto) ? $producto->descripcion_producto: ''}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="imgProducto"><b>&nbsp;&nbsp;Imagen:</b></label>
                                    <input type="file" name="imgProducto" id="imgProducto" class="form-control">
                                    @if(isset($producto) && $producto->imagen != "")
                                        <input type="hidden" name="idImgProducto" id="idImgProducto" value="{{$producto->imagen}}">
                                    @endif
                                </div>
                            
                            </div>

                            <div  id="imgProducto_preview" class="form-group row">

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
                    
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="chkEstadoProducto"><b>&nbsp;&nbsp;Estado:<b></label>
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" name="chkEstadoProducto" id="chkEstadoProducto" {{isset($producto) && $producto->estado == 1 ? 'checked':''}}>  
                                        <label class="custom-control-label" for="chkEstadoProducto">Activo</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="form-group">

                                <p class="help-block font-weight-bold"><span style="color:#AB0505;">Nota: (*) Campos Obligatorios</span></p> 
                                <a class="btn btn-danger btn-icon-split" href="{{ url('/admin/productos') }}"> <span class="icon text-white-50"><img src="{{ url('admin_assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
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

<script src="{{ asset('admin_assets/vendors/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'txtDescripcionProducto' );
    CKEDITOR.config.allowedContent = true;
</script>
<script src="{{ asset('admin_assets/js/productos.js') }}"></script>

@endsection