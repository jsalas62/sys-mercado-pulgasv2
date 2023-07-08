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

                <div class="card" style="border-radius:16px;box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);">
                  
                    <div class="card-body p-5">

                        <h3 class="text-center mb-4">Reestablecer Contraseña</h3>

                        @if (Session::has('message'))
                            <div class="alert alert-success mb-5" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
    
                        <form action="{{ route('forget.password.post') }}" method="POST">

                            @csrf
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Correo Electrónico: </label>
                                <div class="col-md-7">
                                    <input type="text" id="email_address" class="form-control form-login-input" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger mb-3 mt-3">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-pri btn-send-link text-center d-flex justify-content-center ml-4 mr-4 w-100 mt-4">
                                Enviar enlace de restablecimiento de contraseña
                            </button>

                            <div class="mt-2 pb-2 text-center">
                                <a href="{{url('login')}}" class="text-back-login font-weight-medium">Volver al inicio de Sesión</a>
                            </div>

                        </form>
                            
                    </div>
                </div>

            </div>
      
        </div>

    </div>


@endsection

@section('scripts')

<script src="{{ asset('assets/js/login.js') }}"></script> 

@endsection
