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

<div class="col-12">

    <div class="card">

        <form method="POST" action="{{ url('user/contrasenia') }}" enctype="multipart/form-data" id="formPassUser">

            @csrf

            <div class="card-body px-5">

                <h3 class="card-title">Cambio de Contraseña</h3>

                <div class="row mt-4">

                    <div class="col-7">


                        <div class="form-group">
                            <input type="hidden" name="hddusuario_idcontrasenia" id="hddusuario_idcontrasenia" value="{{ isset($usuariodata) ? $usuariodata->user_id : '' }}">
                            <label for="passActualUsuario"><b>Contraseña Actual:</b></label>
                            <input type="password" class="form-control form-custom-input ml-2" id="passActualUsuario"  name="passActualUsuario" placeholder="Ingrese tu Contraseña Actual..">
                        </div>

                        <div class="form-group mt-4">
                            <label for="passNuevaUsuario"><b>Nueva Contraseña:</b></label>
                            <input type="password" class="form-control form-custom-input ml-2" id="passNuevaUsuario"  name="passNuevaUsuario" placeholder="Ingrese tu Nueva Contraseña..">
                        </div>   

                        <div class="form-group mt-4">
                            <label for="telefonoUsuario"><b>Repetir Contraseña:</b></label>
                            <input type="password" class="form-control form-custom-input ml-2" id="passRepetirUsuario"  name="passRepetirUsuario" placeholder="Vuelva a ingresar la nueva Contraseña..">
                        </div>

                    </div>


                </div>

            </div>

            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-icon-split" id="guardarPassUser"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                </div>
            </div>

        </form>

    </div>

</div>

</div> 

</div>


@endsection


@section('scripts')

<script src="{{ asset('assets/js/contrasenia.js') }}"></script>

@endsection