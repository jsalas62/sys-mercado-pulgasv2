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
                    <label for="txtBuscarUsuario" style="font-size:14px;">Usuario:</label>
                    <input type="text" class="form-control form-custom-input" id="txtBuscarUsuario" placeholder="Nombre o Apellido del Usuario...">
                </div>
            </div>

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoUsuarioBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoUsuarioBuscar" id="estadoUsuarioBuscar" class="form-control form-custom-input">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

     
    </div>

    <div class="row px-4">
        <div class="col-xl-12 col-md-12 col-sm-12 d-flex justify-content-end mt-4">

            <div class="form-group mr-20-sm">
                <a type="button" class="btn btn-sm btn-success btn-fw" href="{{ route('user.usuarios.create') }}"><img src="{{ url('admin_assets/images/add2.png') }}" alt="agregar" width="25px"> Agregar usuario</a>
            </div>

        </div>
    </div>

    <div class="row px-4 mt-4">
        <div class="col-12 grid-margin">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                    <i class="fas fa-users"></i>
                        Listado de Usuarios
                    </h4>
                    <section class="tbl-usuarios">
                        @if(isset($usuarios) && count($usuarios) > 0)
                            
                            @include('users.data.usuarios-data')
                        
                        @else 
                        
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th></th>
                                        <th>Usuario</th>
                                        <th>Foto</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="10">No se encontraron registros</td>
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

    <div class="row justify-content-center mt-4 mb-4">
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
                                <td style="font-size:14px">Editar Usuario</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/delete3.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Eliminar Usuario</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/on.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Activar Usuario</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/off.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Desactivar Usuario</td>
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

<script src="{{ asset('assets/js/usuarios.js') }}"></script>

@endsection