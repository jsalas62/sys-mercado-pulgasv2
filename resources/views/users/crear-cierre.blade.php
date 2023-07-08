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

    <div class="row px-4 mt-3">

        <div class="col-12">

            <div class="card">

                <form method="POST" action="{{ url('user/cierre-subasta') }}" enctype="multipart/form-data" id="formProducto">

                    @csrf   
                    
                    <div class="card-body px-5">

                        <h3 class="card-title">Cierre de Subasta</h3>
                        <div class="form-group row mt-5">
                            <div class="col-md-6 col-12">
                                <input type="hidden" name="hddpuja_id" id="hddpuja_id" value="{{$pujaid}}">
                                <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Modo de Entrega:</b></label>
                                <select class="form-control ml-2 selectpicker form-custom-input" name="modoEntrega" id="modoEntrega" data-live-search="true">
                                    <option value="">--Seleccione--</option>
                                    @isset($listadoModos)
                                        @foreach ($listadoModos as $lm)
                                            <option value="{{$lm->modo_id}}">{{$lm->modalidad}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="nombreProducto"><b><span style="color:#AB0505;">(*)</span> Modalidad de Pago:</b></label>
                                <select class="form-control ml-2 selectpicker form-custom-input" name="modoPago" id="modoPago" onchange="mostrarDescripcionPago(this.value)" data-live-search="true">
                                    <option value="">--Seleccione--</option>
                                    <option value="YAPE">Yape</option>
                                    <option value="PLIN">PLIN</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>

                            <!-- <div class="col-md-4 col-12">
                              
                                <label for="nombreProducto"><b> Comisión:</b></label>
                                <input type="number" class="form-control form-custom-input ml-2" id="comisionCierre"  name="comisionCierre" value="0.00">
                            </div> -->
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-12">
                                <label for="imgcomprobante"><b>&nbsp;&nbsp;Comprobante:</b></label>
                                <input type="file" name="imgcomprobante" id="imgcomprobante" class="form-control form-custom-input">
                                <div id="comprobante-preview" class="mt-2">

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer mt-4">
                        <div class="form-group">

                            <p class="help-block font-weight-bold"><span style="color:#AB0505;">Nota: (*) Campos Obligatorios</span></p> 
                            <a class="btn btn-danger btn-icon-split" href="{{ url('/user/pujas') }}"> <span class="icon text-white-50"><img src="{{ url('admin_assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                            <button type="submit" class="btn btn-dark btn-pri btn-icon-split" id="guardarCierre"><span class="icon text-white-50"><img src="{{ url('admin_assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                                                
                        </div>
                    </div>
                    
                </form>

            </div>

        </div>
    
    </div>

</div>

</div>

<!-- Modal Agregar -->
<div class="modal fade" id="ModalDescriopnPago" tabindex="-1" aria-labelledby="ModalCategorialabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md" role="document" style="margin-top:20px;">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#ac56fa">
                <h5 class="modal-title font-weight-bold text-primary" id="tituloModalMedioPago" style="color:white !important">INFORMACIÓN DE MEDIO DE PAGO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalPago()"></button>
            </div>

            <div class="modal-body">
            
                <div class="row">

                    <div class="col-lg-12">

                        <div class="card mb-4">

                            <div class="card-body">

                                <div class="dv-info-pago"></div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" id="btnCerrarDescripcionPago" data-bs-dismiss="modal" onclick="limpiarModalPago()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
            
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    //proceso para generar ID de manera aleatoria
    const chars ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    function generateRandomId(length) {
        let result = '';
        const charactersLength = chars.length;
        for ( let i = 0; i < length; i++ ) {
            result += chars.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

    window.mostrarDescripcionPago = function(value)
    {
        $('.dv-info-pago').html("");
        if(value == "YAPE")
        {
            $('#ModalDescriopnPago').modal('show');
            $('.dv-info-pago').html('<p>Número de telefono : +51 987 477 559</p>'+
                                    '<p>Titular: Jorge Salas</p>'+
                                    '<p>1. Ingresa a tu app movil YAPE, busca y eligue nuestro contacto</p>'+
                                    '<p>2. Seleccionas pagar</p>'+
                                    '<p>3. Ingresa el monto, dale "Enviar Pago" y ¡listo!</p>'+
                                    '<p>Obligatario : Al momento de hacer el pago en referencias indicar</p>'+
                                    '<p>su numero de whatsapp.</p>');
        }
        else if(value == "PLIN")
        {
            $('#ModalDescriopnPago').modal('show');
            $('.dv-info-pago').html('<p>Número de telefono : +51 987 477 559</p>'+
                                    '<p>Titular: Jorge Salas</p>'+
                                    '<p>1. Ingresa a tu app movil PLIN, busca y eligue nuestro contacto</p>'+
                                    '<p>2. Seleccionas pagar</p>'+
                                    '<p>3. Ingresa el monto, dale "Enviar Pago" y ¡listo!</p>'+
                                    '<p>Obligatario : Al momento de hacer el pago en referencias indicar</p>'+
                                    '<p>su numero de whatsapp.</p>');
        }
        else if(value == "Transferencia")
        {
            $('#ModalDescriopnPago').modal('show');
            $('.dv-info-pago').html('<p>Titular: Jorge Salas</p>'+
                                    '<p>Ahorros Soles N° de cuenta :191 XXXXXXXXXXXXXX'+
                                    '<p>(Transferencias Internet sin cargo)'+
                                    '<p>(Pagos en ventanilla agregar 9 soles)</p>'+
                                    '<p>Al momento de hacer la transferencia Es obligatorio poner nuestro email en el destinatario</p>'+
                                    '<p>Email : contacto@mercadopulgas.com</p>');
        }
        
    }

    window.limpiarModalPago =  function()
    {
        $('.dv-info-pago').html("");
    }

    
    $('#imgcomprobante').change(function(){
        let comprobante = $('input[name="imgcomprobante"]')[0].files;
        let url = $('meta[name=app-url]').attr("content") +  "/comprobante/imgTmp";
        let comprobantepago = new FormData();
        let id = generateRandomId(3);
        comprobantepago.append("imagen",comprobante[0]);
        comprobantepago.append("indice",1);
        $('#comprobante-preview').html("");
        $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: comprobantepago,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(response) {
                    if(response.code==200)
                    {
                        let urlraiz = $('meta[name=app-url]').attr("content") + "/";
                        let urlimage = urlraiz + response.data.url;
                        let img_id = 'comprobanteimg' + id;
                        // previewtmpimage_col3(urlimage, 'imgProducto_preview',img_id, response.data.name, response.data.size, 'imgproducto', 'imagen-action', 'producto_id');
                        $('#comprobante-preview').append("<div class='img-div col-md-3 col-6' id='comprobanteimg"+id+"'>" +
                                "<img src='"+urlimage+"' class='img-fluid image img-thumbnail' title='"+response.data.name+"' height='200px'>"+
                                "<input value='"+response.data.name+"|*|"+response.data.size+"' name='comprobanteimg' type='hidden'>" +
                                "</div>");
                        document.getElementById('comprobantepago').value="";
                    }
                    else  if(response.code == "422")
                    {
                        document.getElementById('comprobantepago').value="";
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
                        document.getElementById('comprobantepago').value="";

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar actualizar el registro!'
                        })
                    }
                },
                error: function(response) {
                    document.getElementById('comprobantepago').value="";
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
    });

    $('#formProducto').submit(function(event){
        event.preventDefault();
        $("#guardarCierre").prop('disabled', true);
        let url = $('meta[name=app-url]').attr("content") + "/user/crear-cierre";
        dataCierre = $(this).serialize();

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: dataCierre,
                success: function(response) {
                    $("#guardarCierre").prop('disabled', false);
                    if(response.code == "200")
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha registrado el Cierre de la subasta correctamente',
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
                    else if(response.code == "422")
                    {
                        let errors = response.errors;
                        let productoValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                productoValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                                productoValidation  + 
                                    '</ul>'
                        });
                  
                    }
        
                    else 
                    {
                        $("#guardarCierre").prop('disabled', false);

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar guardar el registro!'
                        });
                    }
                }
            });


    });

</script>

@endsection