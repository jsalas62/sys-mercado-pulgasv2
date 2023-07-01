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
 

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtBuscarProduto" style="font-size:14px;">Producto: </label>
                <input type="text" class="form-control form-custom-input" id="txtBuscarProduto" placeholder="Nombre del Producto...">
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="BuscarCategoriaProducto" style="font-size:14px;">Categoría: </label>
                <select id="BuscarCategoriaProducto" class="form-control form-custom-input selectpicker" data-live-search="true">
                    <option value="">--Seleccione--</option>
                    @if(isset($categorias) && count($categorias)>0)
                        @foreach ($categorias as $ctg)
                            <option value="{{$ctg['categoria_id']}}">{{$ctg['categoria']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
            
    </div>

    <div class="row px-4 mt-3 d-flex align-items-center">

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoProductoBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoProductoBuscar" id="estadoProductoBuscar" class="form-control form-custom-input">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12 mt-3">

            <div class="form-group mr-20-sm">
                <a type="button" class="btn btn-success btn-fw"  href="{{ route('user.productos.create') }}"><img src="{{ url('admin_assets/images/add2.png') }}" alt="agregar" width="25px"> Agregar Producto</a>
            </div>

        </div>

    </div>

    
    <div class="row mt-4">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                    <i class="fas fa-dolly-flatbed"></i>
                        Listado de Productos
                    </h4>
                    <section class="productos">
                        @if(isset($productos) && count($productos) > 0)
                            
                            @include('users.data.productos-data')
                        
                        @else 
                        
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th>Categorías</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="7">No se encontraron registros</td>
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
                                <td style="font-size:14px">Editar Producto</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/delete3.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Eliminar Producto</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/on.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Activar Producto</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/off.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Desactivar Producto</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/productos-main.js') }}"></script>

@endsection