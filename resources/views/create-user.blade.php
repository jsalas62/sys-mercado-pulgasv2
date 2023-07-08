@extends('temlate')

@section('content')

    <div class="container">

        <div class="row mt-3">

            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="{{url('/')}}">
                    <img class="img-fluid logo-admin" src="{{asset('assets/images/logo22.jpg')}}" width="328">
                </a>
                <a href="{{url('/')}}" class="login-back-link blue">
                    <i class="fas fa-arrow-left"></i>
                    <span>Regresar a la tienda</span>
                </a>
            </div>

        </div>

    </div>

    <div class="container-fluid container-xxl mt-3">

        <div class="row row-login d-flex justify-content-center flex-wrap">
 
            <div class="col-lg-7 col-md-10 p-2 col-12 login-wrap">

                <div class="card p-4" style="border-radius:32px;box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);">
                    <p class="login-subtitle">¿Aún no tienes cuenta?</p>
                    <h3 class="login-title">Regístrate</h3>
                    <form id="create-form" class="create-form mt-4" action="/register-user" method="POST">

                        @csrf
                        <div class="form-group row">

                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control form-control-lg form-login-input" id="nameUsuario" name="nameUsuario" placeholder="Nombres">
                            </div>

                            <div class="col-md-6 col-12">
                                <input type="text" class="form-control form-control-lg form-login-input" id="apellidosUsuario" name="apellidosUsuario" placeholder="Apellidos">
                            </div>

                        </div>
                    
                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg form-login-input" id="emailUsuario" name="emailUsuario" placeholder="Correo Electrónico">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg form-login-input" id="telUsuario" name="telUsuario" placeholder="Teléfono">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg form-login-input" id="dirUsuario" name="dirUsuario" placeholder="Dirección">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg form-login-input" id="usuarioCreate" name="usuarioCreate" placeholder="Usuario">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg form-login-input" id="passwordCreateUsuario" name="passwordCreateUsuario" placeholder="Contraseña">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg form-login-input" id="passwordSameCreateUsuario" name="passwordSameCreateUsuario" placeholder="Repetir Contraseña">
                            </div>
                        </div>

                        <div class="mt-4 pl-4 pr-4 pb-2 mt-4 text-center">
                            <button type="submit" class="btn btn-lg font-weight-medium btn-pri">Crear Cuenta</button>
                        </div>

                        <div class="mt-2 pl-4 pr-4 pb-2 text-center">
                            <a href="{{url('login')}}" class="font-weight-medium">Iniciar Sesión</a>
                        </div>

                    </form>

                    @if(Session::has('msg'))
                    <div class="container mt-3">
                        <div class="alert-create alert-danger p-3" style="display:none;">
                            {{ Session::get('msg') }}
                            @if ($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/login.js') }}"></script> 

@endsection
