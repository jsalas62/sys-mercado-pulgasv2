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

                <form method="POST" action="{{ url('user/user-data') }}" enctype="multipart/form-data" id="formDataUser">

                    @csrf

                    <div class="card-body px-5">

                        <h3 class="card-title">Mis Datos Personales</h3>

                        <div class="row mt-4">

                            <div class="col-7">


                                <div class="form-group">
                                    <input type="hidden" name="hdddatausuario_id" id="hdddatausuario_id" value="{{ isset($usuariodata) ? $usuariodata->user_id : '' }}">
                                    <label for="nombreUsuario"><b> Nombres:</b></label>
                                    <input type="text" class="form-control form-custom-input ml-2" id="nombredatausuario"  name="nombredatausuario" placeholder="Ingrese el Nombre del Usuario.." value="{{ isset($usuariodata) ? $usuariodata->nombres : '' }}">
                                </div>

                                <div class="form-group mt-4">
                                    <label for="apellidoUsuario"><b>Apellidos:</b></label>
                                    <input type="text" class="form-control form-custom-input ml-2" id="apellidodatausuario"  name="apellidodatausuario" placeholder="Ingrese el Apellido del USuarios.." value="{{ isset($usuariodata) ? $usuariodata->apellidos : '' }}">
                                </div>   

                                <div class="form-group mt-4">
                                    <label for="telefonoUsuario"><b>Teléfono:</b></label>
                                    <input type="text" class="form-control form-custom-input ml-2" id="telefonodatausuario"  name="telefonodatausuario" placeholder="Ingrese el Teléfono del Usuario.." value="{{ isset($usuariodata) ? $usuariodata->telefono : '' }}">
                                </div>

                                <div class="form-group mt-4">
                                    <label for="DireccionDataUsuario"><b>Dirección:</b></label>
                                    <input type="text" class="form-control form-custom-input ml-2" id="DireccionDataUsuario"  name="DireccionDataUsuario" placeholder="Ingrese la Dirección del Usuario.." value="{{ isset($usuariodata) ? $usuariodata->direccion : '' }}">
                                </div>

                                <div class="form-group mt-4">
                                    <label for="emailUsuario"><b>Email:</b></label>
                                    <input type="text" class="form-control form-custom-input ml-2" id="emaildatausuario"  name="emaildatausuario" placeholder="Ingrese el Email del Usuario.." readonly value="{{ isset($usuariodata) ? $usuariodata->email : '' }}">
                                </div>

                            </div>

                            <div class="col-5">

                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="fotoDataUser"><b>&nbsp;&nbsp;Foto:</b></label>
                                        <input type="file" name="fotoDataUser" id="fotoDataUser" class="form-control">
                                        @if(isset($usuariodata->foto))
                                            <input type="hidden" name="fotoDataActualUsuario" id="fotoDataActualUsuario" value="{{$usuariodata->foto}}">
                                        @endif
                                    </div>

                                </div>

                                <div  id="fotoDataUsuario_preview" class="form-group row mt-4">

                                    @if(isset($usuariodata) && $usuariodata->foto!="")

                                        <div class="img-div col-12 h-100" id="fotoDataUsuario{{$usuariodata->user_id}}">
                                            <img src="{{URL::asset($usuariodata->foto)}}" class="img-fluid image img-thumbnail" title="{{$usuariodata->foto_name}}">
                                            <div class="middle">
                                                <button type="button" id="fotodata-action-icon" value="fotoDataUsuario{{$usuariodata->user_id}}" class="btn btn-danger" name="{{$usuariodata->foto}}" temporal="0" foto_id='{{$usuariodata->user_id}}'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <a class="btn btn-info" download href="{{URL::asset($usuariodata->foto)}}"><i class="fas fa-download"></i></a>
                                            </div>
                                            <input value="{{$usuariodata->foto}}|*|2023|*|0" name="fotodatausuario" type="hidden">
                                        </div> 

                                    @endif

                                </div>  

                            </div>

                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-pri btn-icon-split" id="guardarDataUser"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div> 

</div>


@endsection


@section('scripts')

<script src="{{ asset('assets/js/misdatos.js') }}"></script>

@endsection