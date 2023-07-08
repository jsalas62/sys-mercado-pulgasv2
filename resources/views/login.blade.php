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

        <div class="row row-login d-flex justify-content-center flex-wrap mt-4">

            <div class="col-lg-6 col-md-8 col-12 login-wrap">

                <div class="card p-5" style="border-radius:32px;box-shadow: 3px 3px purple, -1em 0 0.4em gray;">
                    <h3 class="login-title">Ingresar</h3>
                    <form id="login-form" class="login-form" action="{{ url('login') }}"  method="POST">
                        @csrf
                    
                        <div class="form-group pl-4 pr-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg form-login-input" id="LoginUsuario" name="LoginUsuario" placeholder="Usuario">
                            </div>
                        </div>

                        <div class="form-group pl-4 pr-4 mt-4">
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg form-login-input" id="LoginPassword" name="LoginPassword" placeholder="Contraseña">
                            </div>
                        </div>
                        
                        <div class="mt-4 pl-4 pr-4 pb-2 mt-4 text-center">
                            <button type="submit" class="btn btn-lg font-weight-medium btn-pri">Ingresar</button>
                        </div>

                        <div class="mt-4 pl-4 pr-4 pb-2 text-center">
                            <a href="{{url('create-user')}}" class="font-weight-medium">¿No tienes cuenta?, Regístrate</a>
                        </div>

                        <div class="mt-2 pl-4 pr-4 pb-2 text-center">
                            <a href="{{route('forget.password.get')}}" class="font-weight-medium">¿Olvidaste tu Contraseña?</a>
                        </div>

                    </form>

                    @if(Session::has('message'))
                    <div class="container">
                        @if(Session::has('success'))
                            <div class="alert alert-success" style="display:none;">
                        @else
                            <div class="alert alert-danger" style="display:none;">
                        @endif
                        
                            {{ Session::get('message') }}
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

                    
                    @if(Session::has('message2'))
                    <div class="container">
                        <div class="alert alert-success" style="display:none;">
                        
                            {{ Session::get('message2') }}
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
