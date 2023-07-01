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

        <h3 class="page-title">
            {{ isset($usuario) ? 'FORMULARIO DE ACTUALIZACIÓN DE USUARIO' : 'FORMULARIO DE REGISTRO DE USUARIO' }}
        </h3>
        
    </div>

    <div class="row px-4 mt-3">

        <div class="col-12">
            
            <div class="card">

                <form method="POST" action="{{ url('admin/usuarios') }}" enctype="multipart/form-data" id="formUsuario">

                @csrf

                    <div class="card-body px-5">

                        <h3 class="card-title">Datos del Usuario</h3>

                        
                        <div class="form-group row mt-5">

                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="hddusuario_id" id="hddusuario_id" value="{{ isset($usuario) ? $usuario->user_id : '' }}">
                                <label for="nombreUsuario"><b><span style="color:#AB0505;">(*)</span> Nombres:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="nombreUsuario"  name="nombreUsuario" placeholder="Ingrese el Nombre del Usuario.." value="{{ isset($usuario) ? $usuario->nombres : '' }}">
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="apellidoUsuario"><b><span style="color:#AB0505;">(*)</span> Apellidos:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="apellidoUsuario"  name="apellidoUsuario" placeholder="Ingrese el Apellido del USuarios.." value="{{ isset($usuario) ? $usuario->apellidos : '' }}">
                            </div>

                        </div>

                        <div class="form-group row mt-4">

                            <div class="col-md-6 col-sm-12">
                                <label for="emailUsuario"><b><span style="color:#AB0505;">(*)</span> Email:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="emailUsuario"  name="emailUsuario" placeholder="Ingrese el Email del Usuario.." value="{{ isset($usuario) ? $usuario->email : '' }}">
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="cborolusuario"><b>&nbsp;&nbsp;Rol:</b></label>
                                <select class="form-control form-custom-input ml-2 selectpicker" name="cborolusuario" id="cborolusuario" data-live-search="true">
                                    <option value="">--Seleccione--</option>
                                    @foreach($roles as $rol)
                                        <option value="{{$rol->id}}" {{isset($rol_user) && in_array($rol->id, $rol_user) ? 'selected' : ''}}>{{$rol->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group row mt-4">

                            <div class="col-md-6 col-sm-12">
                                <label for="telefonoUsuario"><b>Teléfono:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="telefonoUsuario"  name="telefonoUsuario" placeholder="Ingrese el Teléfono del Usuario.." value="{{ isset($usuario) ? $usuario->telefono : '' }}">
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="txtUsuario"><b><span style="color:#AB0505;">(*)</span> Usuario:</b></label>
                                <input type="text" class="form-control form-custom-input ml-2" id="txtUsuario"  name="txtUsuario" placeholder="Ingrese el Usuario.." value="{{ isset($usuario) ? $usuario->usuario : '' }}">
                            </div>

                        </div>

                        <div class="form-group row mt-4">

                            <div class="col-md-6 col-sm-12">
                                <label for="contraseniaUsuario"><b><span style="color:#AB0505;">(*)</span> Contraseña:</b></label>
                                <input type="password" class="form-control form-custom-input ml-2" id="contraseniaUsuario"  name="contraseniaUsuario" placeholder="Ingrese la Contraseña del Usuario.." 
                                @isset($usuario)
                                    data-toggle="tooltip" data-placement="top" title="Ingrese la nueva contraseña si desea modificarla, caso contrario dejarla en blanco"
                                @endisset
                                >
                                <input type="hidden" name="contaseniaUsuarioActual" id="contaseniaUsuarioActual" value="{{ isset($usuario) ? $usuario->contrasenia : '' }}">
                                <small class="text-muted  ml-2"><span style="color:#AB0505;">Las contraseñas no deben contener espacios en blanco</span></small>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="confirmarContraseniaUsuario"><b><span style="color:#AB0505;">(*)</span> Confirmar Contraseña:</b></label>
                                <input type="password" class="form-control form-custom-input ml-2" id="confirmarContraseniaUsuario"  name="confirmarContraseniaUsuario" placeholder="Ingrese el Usuario.."
                                @isset($usuario)
                                    data-toggle="tooltip" data-placement="top" title="confirme la contraseña si desea modificarla, caso contrario dejarla en blanco"
                                @endisset
                                >
                                <small class="text-muted  ml-2"><span style="color:#AB0505;">Las contraseñas no deben contener espacios en blanco</span></small>
                            </div>

                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-6 col-sm-12">
                                <label for="chkEstadoUsuario"><b>&nbsp;&nbsp;Estado:</b></label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="chkEstadoUsuario" id="chkEstadoUsuario" {{isset($usuario) && $usuario->estado == 1 ? 'checked':''}}>  
                                    <label class="custom-control-label" for="chkEstadoUsuario">Activo</label>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-12">
                                <label for="fotoUsuario"><b>&nbsp;&nbsp;Foto:</b></label>
                                <input type="file" name="fotoUsuario" id="fotoUsuario" class="form-control">
                                @if(isset($usuario->foto))
                                    <input type="hidden" name="fotoActualUsuario" id="fotoActualUsuario" value="{{$usuario->foto}}">
                                @endif
                            </div>

                        </div>

                        <div  id="fotoUsuario_preview" class="form-group row mt-4">

                            @if(isset($usuario) && $usuario->foto!="")

                                <div class="img-div col-md-3 col-6" id="fotoUsuario{{$usuario->user_id}}">
                                    <img src="{{URL::asset($usuario->foto)}}" class="img-fluid image img-thumbnail" title="{{$usuario->foto_name}}">
                                    <div class="middle">
                                        <button type="button" id="foto-action-icon" value="fotoUsuario{{$usuario->user_id}}" class="btn btn-danger" name="{{$usuario->foto_name}}" temporal="0" foto_id='{{$usuario->user_id}}'>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-info" download href="{{URL::asset($usuario->foto)}}"><i class="fas fa-download"></i></a>
                                    </div>
                                    <input value="{{$usuario->foto}}|*|2023|*|0" name="fotousuario" type="hidden">
                                </div> 

                            @endif

                        </div>  

                    </div>

                    <div class="card-footer">
                        <div class="form-group">

                            <p class="help-block font-weight-bold"><span style="color:#AB0505;">Nota: (*) Campos Obligatorios</span></p> 
                            <a class="btn btn-danger btn-icon-split" href="{{ url('/user/usuarios') }}"> <span class="icon text-white-50"><img src="{{ url('admin_assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                            <button type="submit" class="btn btn-dark btn-icon-split" id="guardarUsuario"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                                                
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

    <script>

        $('#fotoUsuario').change(function(){   
            let foto = $('input[name="fotoUsuario"]')[0].files;
            let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios/subirImagenTmp";
            let fotoData = new FormData();
            let id = generateString(3);
            fotoData.append("imagen",foto[0]);
            fotoData.append("indice",1);
            $('#fotoUsuario_preview').html("");
            $("#guardarUsuario").prop('disabled', true);
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: fotoData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    if(response.code==200)
                    {
                        let urlraiz = $('meta[name=app-url]').attr("content") + "/";
                        let urlimage = urlraiz + response.data.url;
                        let img_id = 'fotoUsuario' + id;
                        previewtmpimage_col3(urlimage, 'fotoUsuario_preview',img_id, response.data.name, response.data.size, 'fotousuario', 'foto-action', 'foto_id');
                        document.getElementById('fotoUsuario').value="";
                    }
                    else  if(response.code == "422")
                    {
                        document.getElementById('fotoUsuario').value="";
                        let errors = response.errors;
                        let imgvalidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                imgvalidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            imgvalidation  + 
                                    '</ul>'
                        });
                    }
                    else
                    {
                        document.getElementById('fotoUsuario').value="";

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar actualizar el registro!'
                        })
                    }
                },
                error: function(response) {
                    document.getElementById('fotoUsuario').value="";
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
        });

        $('body').on('click', '#foto-action-icon', function(evt){
            let divNameImg = this.value;
            let filenameImg = $(this).attr('name');
            let temporalImg = $(this).attr('temporal');
            let div_id  = $(this).attr('foto_id');
            let superpuesto = 0;

            if(temporalImg == 1)
            {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios/eliminarImagenTmp";
                deleteTempImg(divNameImg, filenameImg, temporalImg, url);
            }
            else if(temporalImg == 0)
            {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios/eliminarFoto";
                deleteImg(divNameImg, filenameImg, div_id, temporalImg, url, superpuesto);
                $('#fotoActualUsuario').val("");
            }
            
            evt.preventDefault();
        });

        $('#guardarUsuario').click(function(event){
            event.preventDefault();
            let hddusuario_id = $('#hddusuario_id').val();
            if(hddusuario_id!="")
            {
                actualizarUsuario(hddusuario_id);
            }
            else 
            {
                guardarUsuario();
            }
        });

        window.guardarUsuario = function(){
            $("#guardarUsuario").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/user/usuarios";
            let formData = new FormData($("#formUsuario")[0]); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    if(response.code == "200")
                    {   
                            Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha registrado el Usuario correctamente',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = response.url;
                                }
                            });

                    }
                    else  if(response.code == "422")
                    {
                        let errors = response.errors;
                        let usuarioValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                usuarioValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                                usuarioValidation  + 
                                    '</ul>'
                        });
                    }
                },
                error: function(response) {
                    $("#guardarUsuario").prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    })
                }
            });
        }

        window.actualizarUsuario = function(hddusuario_id)
        {
            $("#guardarUsuario").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/user/usuarios/" + hddusuario_id;
            let FormDataUsuarioEditar = new FormData($("#formUsuario")[0]); 
            FormDataUsuarioEditar.append('_method', 'PUT');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                enctype: 'multipart/form-data',
                data: FormDataUsuarioEditar,
                processData: false,  
                contentType: false,  
                success: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    if(response.code == "200")
                    {   
                            Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha actualizado el Usuario correctamente',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = response.url;
                                }
                            });

                    }
                    else  if(response.code == "422")
                    {
                            let errors = response.errors;
                            let usuarioValidation = '';

                            $.each(errors, function(index, value) {

                                if (typeof value !== 'undefined' || typeof value !== "") 
                                {
                                    usuarioValidation += '<li>' + value + '</li>';
                                }

                            }); 

                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                usuarioValidation  + 
                                        '</ul>'
                            });
                    }
                    else if(response.code=="423")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'La contraseña debe tener un mínimo de 6 carácteres'
                            });
                    }
                    else if(response.code=="424")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Las Contraseñas no coinciden!'
                            });
                    }
                },
                error: function(response) {
                    $("#guardarUsuario").prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    })
                }
            });
        }

    </script>

@endsection