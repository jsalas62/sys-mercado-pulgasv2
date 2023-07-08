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

    <div class="container-fluid container-xxl mt-5">
        <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card" style="border-radius:16px;box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);">

                  <div class="card-body p-5">

                    <h3 class="text-center mb-4">Cambio de Contraseña</h3>
  
                      <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
  
                          <div class="form-group row mt-2">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">Correo Electrónico:</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control form-login-input" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row mt-3">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña:</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control form-login-input" name="password" required autofocus>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row mt-3">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña:</label>
                              <div class="col-md-6">
                                  <input type="password" id="password-confirm" class="form-control form-login-input" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="col-md-6 offset-md-4 mt-4">
                              <button type="submit" class="btn btn-primary btn-pri">
                                  Cambiar Contraseña
                              </button>
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