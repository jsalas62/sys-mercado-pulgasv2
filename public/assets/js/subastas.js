function loadSubastas(page)
{
    let url='';
    let productosubasta = $('#buscarProductoSubasta').val();
    let estadosubasta = $('#estadoSubastaBuscar').val(); 
    url=$('meta[name=app-url]').attr("content")  + "/user" + "/subastas?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {producto: productosubasta, estado: estadosubasta}
    }).done(function (data) {
        $('.subastas').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#buscarProductoSubasta').on('change', function (e ){
    url=$('meta[name=app-url]').attr("content") + "/user" + "/subastas";
    let estadoBuscarCBO = $('#estadoSubastaBuscar').val();
    $.ajax({
        url: url,
        method:'GET',
        data: {producto: this.value, estado: estadoBuscarCBO}
    }).done(function (data) {
        $('.subastas').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
})


$('#estadoCategoriaBuscar').on('change', function (e ){
    url=$('meta[name=app-url]').attr("content") + "/user" + "/subastas";
    let productoBuscarCBO = $('#buscarProductoSubasta').val();
    $.ajax({
        url: url,
        method:'GET',
        data: {producto: productoBuscarCBO, estado: this.value}
    }).done(function (data) {
        $('.subastas').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
})


window.limpiarModalSubasta = function()
{
    $('#tituloModalSubasta').html('AGREGAR SUBASTA');
    $('#hddsubasta_id').val("");
    $('#cboProductoId').val("");
    $("#cboProductoId").selectpicker("destroy");
    $("#cboProductoId").selectpicker();
    $('#txtPrecioMinimo').val("");
    // $('#txtPrecioMinimo').prop('disabled',false);
    $('#dateFechaInicio').val("");
    $('#dateFechaFin').val("");
}

$('#formSubasta').submit(function(event){
    event.preventDefault();
    let hddsubasta_id = $('#hddsubasta_id').val();
    console.log(hddsubasta_id);
    if(hddsubasta_id!="")
    {
       actualizarSubasta(hddsubasta_id);
    }
    else 
    {
        guardarSubasta(hddsubasta_id);
    }
});

window.guardarSubasta = function(hddusuario_id){
    $("#btnGuardarSubasta").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") + "/user/subastas";
    let data = {
        producto_id: $("#cboProductoId").val(),
        precio_minimo: $("#txtPrecioMinimo").val(),
        fecha_inicio: $("#dateFechaInicio").val(),
        fecha_fin: $("#dateFechaFin").val(),
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        data: data,
        success: function(response) {
            $("#btnGuardarSubasta").prop('disabled', false);
            if(response.code == "200")
            {   
                
                $("#ModalSubasta").modal('hide');
                limpiarModalSubasta();
                loadSubastas();
                // loadcategorias();
                // limpiarModalCategoria();
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se ha registrado la Subasta correctamente'
                });

            }
            else  if(response.code == "422")
            {
                let errors = response.errors;
                let subastavalidation = '';

                $.each(errors, function(index, value) {

                    if (typeof value !== 'undefined' || typeof value !== "") 
                    {
                        subastavalidation += '<li>' + value + '</li>';
                    }

                }); 

                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    html: '<ul>'+
                    subastavalidation  + 
                            '</ul>'
                });
            }
            else  if(response.code == "423")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'El Precio minimo debe ser mayor a 0!'
                })
            }
            else  if(response.code == "424")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'La Fecha de Fin no debe ser menor a la Fecha de Inicio!'
                })
            }
            else  if(response.code == "426")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'La Fecha de Inicio no debe ser menor a la Fecha Actual!'
                })
            }
        },
        error: function(response) {
            $("#btnGuardarSubasta").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            })
        }
    });
}

window.mostrarSubasta = function(subasta_id)
{
    url=$('meta[name=app-url]').attr("content") + "/user" + "/subastas/" +subasta_id;
    $("#ModalSubasta").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        console.log(data.producto_id);
        $('#tituloModalSubasta').html('EDITAR SUBASTA');
        $('#hddsubasta_id').val(subasta_id);
        $('#cboProductoId').val(data.producto_id);
        $("#cboProductoId").selectpicker("destroy");
        $("#cboProductoId").selectpicker();
        // $('#txtPrecioMinimo').prop('disabled',true);
        $('#txtPrecioMinimo').val(data.precio_min);
        $('#dateFechaInicio').val(data.tiempo_inicio);
        $('#dateFechaFin').val(data.tiempo_fin);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.actualizarSubasta = function(hddsubasta_id)
{
    $("#btnGuardarSubasta").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/subastas/" + hddsubasta_id;
    let data = {
        hddsubasta_id: hddsubasta_id,
        producto_id: $("#cboProductoId").val(),
        precio_minimo: $("#txtPrecioMinimo").val(),
        fecha_inicio: $("#dateFechaInicio").val(),
        fecha_fin: $("#dateFechaFin").val(),
    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "PUT",
        data: data,
        success: function(response) {
            $("#btnGuardarSubasta").prop('disabled', false);
            if(response.code == "200")
            {
                    limpiarModalSubasta();
                    $("#ModalSubasta").modal('hide');
                    loadSubastas();

                    Swal.fire({
                        icon: 'success',
                        title: 'ÉXITO!',
                        text: 'Se ha actualizado la Subasta correctamente'
                    });
            }
            else if(response.code == "422")
            {
                let errors = response.errors;
                if (typeof errors.categoria !== 'undefined' || typeof errors.categoria !== "") 
                {
                    categoriavalidation = '<li>' + errors.categoria + '</li>';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    html: '<ul>'+
                    categoriavalidation  + 
                            '</ul>'
                });
            }
            else  if(response.code == "423")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'El Precio minimo debe ser mayor a 0!'
                })
            }
            else  if(response.code == "424")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'La Fecha de Fin no debe ser menor a la Fecha de Inicio!'
                })
            }
            else if(response.code=="426")
            {
                Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'La Subasta del  producto ya Existe!'
                    });
            }
            else  if(response.code == "427")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'La Fecha de Inicio no debe ser menor a la Fecha Actual!'
                })
            }
        },
        error: function(response) {
            $("#btnGuardarCategoria").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar actualizar el registro!'
            })
        }
    });
}

window.eliminarSubasta = function(hddsubasta_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de eliminar la Subasta?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/subastas/"  + hddsubasta_id;
                let data = {
                    subasta_id: hddsubasta_id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "DELETE",
                    data: data,
                    success: function(response) {
                        // console.log(response);
                        if(response.code == "200")
                        {
                            loadSubastas();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha eliminado la Subasta correctamente'
                            });
                        }
                        else  if(response.code == "202")
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'No se puede eliminar la Subasta, porque tiene pujas registradas'
                            })
                        }
                    },
                    error: function(response) {                
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar eliminar el registro!'
                        })
                    }
                });
            }
    })
}

window.terminarSubasta = function(hddsubasta_id)
    {
        Swal.fire({
            icon: 'warning',
            title: 'Está seguro de Finalizar la Subastas?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Finalizar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/subastas" +  "/finalizar/" + hddsubasta_id;
                    let data = {
                        subasta_id: hddsubasta_id
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "POST",
                        data: data,
                        success: function(response) {
                            // console.log(response);
                            if(response.code == "200")
                            {
                                loadSubastas();
                               
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha Finalizado la Subasta correctamente'
                                });
                                // document.location.reload(true)
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Se ha producido un error al intentar desactivar el registro!'
                            })
                        }
                    });
                }
            })
}

window.verPujas = function(hddsubasta_id)
{
    url=$('meta[name=app-url]').attr("content") + "/user" + "/ver-pujas/" +hddsubasta_id;
    $("#ModalVerPujas").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('.verPujasTbl').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });

}

window.limpiarModalVerPujas = function()
{
    $('.verPujasTbl').html("");
}

window.showGanador = function(subasta_id)
{
    url=$('meta[name=app-url]').attr("content") + "/user/subastas" + "/getDataGanador/" + subasta_id;
    $("#ModalGanadorData").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('#ModalTitleDataGanador').html('Datos del Ganador')
        $('#lblNGanador').html(data.nombres)
        $('#lblAGanador').html(data.apellidos)
        $('#lblEGanador').html(data.email)
        $('#lblTGanador').html(data.telefono)
        $('#lblDGanador').html(data.direccion)
        $('#lblUGanador').html(data.usuario)
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.LimpiarGanadorModal = function()
{
    $('#ModalTitleDataGanador').html('')
    $('#lblNGanador').html('')
    $('#lblAGanador').html('')
    $('#lblEGanador').html('')
    $('#lblTGanador').html('')
    $('#lblDGanador').html('')
    $('#lblUGanador').html('')
}