@extends('admin.master')

@section('title', 'Módulo de Usuario')

@section('content')

    <div class="content-wrapper">

        <div class="page-header row">

            <h3 class="page-title">
                ADMINISTRADOR DE USUARIOS
            </h3>

            <div class="template-demo mt-20">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom"">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="colorfont"> <i class="fas fa-fw fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> <i class="fas fa-users"></i> Usuarios</li>
                    </ol>
                </nav>
            </div>

        </div>

        <div class="row">

            <div class="col-xl-12">
                <div class="form-group">
                    <h5 class="mb-3">Buscar por:</h5>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="txtBuscarUsuario" style="font-size:14px;">Usuario:</label>
                    <input type="text" class="form-control form-control-sm" id="txtBuscarUsuario" placeholder="Nombre o Apellido del Usuario...">
                </div>
            </div>

            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="estadoUsuarioBuscar" style="font-size:14px;">Estado:</label>
                    <select name="estadoUsuarioBuscar" id="estadoUsuarioBuscar" class="form-control">
                        <option value="_all_">--Seleccione--</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>


            <div class="col-xl-5 col-md-6 col-sm-12">
                <div class="form-group mr-20-sm">
                    <a type="button" class="btn btn-sm btn-dark btn-fw"  href="{{ route('admin.usuarios.create') }}"><img src="{{ url('admin_assets/images/add2.png') }}" alt="agregar" width="25px"> Agregar Usuario</a>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-12 grid-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                        <i class="fas fa-users"></i>
                            Listado de Usuarios
                        </h4>
                        <section class="tbl-usuarios">
                            @if(isset($usuarios) && count($usuarios) > 0)
                                
                                @include('admin.data.usuarios-data')
                            
                            @else 
                            
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombres Completo</th>
                                            <th>Email</th>
                                            <th>Teléfono</th></th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Foto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td align="center" colspan="9">No se encontraron registros</td>
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

        <div class="row justify-content-center">
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

<script src="{{ asset('admin_assets/js/usuarios.js') }}"></script>

@endsection