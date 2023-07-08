function loadCierres(page)
{
    let url='';
    let cierreEstado = $('#estadoCierreBuscar').val();
    url=$('meta[name=app-url]').attr("content")  + "/user" + "/cierre-subasta?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {estado: cierreEstado}
    }).done(function (data) {
        $('.cierres').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#estadoCierreBuscar').on('change', function (e ){
    url=$('meta[name=app-url]').attr("content") + "/user" + "/cierre-subasta";
    $.ajax({
        url: url,
        method:'GET',
        data: {estado: this.value}
    }).done(function (data) {
        $('.cierres').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
})



window.limpiarShowComprobante = function() {
    $('#imgshow').attr('src',"");
}

window.showComprobante = function(imagen)
{
    // console.log(comprobante);
    $("#ModalImagen").modal('show');
    $('#imgshow').attr('src', imagen);
}

window.aprobarCierre = function(cierre_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de Aprobar el cierre?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Aprobar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/cierre-subasta" +  "/aprobar/" + cierre_id;
                let data = {
                    cierre_id: cierre_id
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
                            loadCierres();
                           
                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha Aprobado el cierre correctamente'
                            });
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar aprobar el registro!'
                        })
                    }
                });
            }
        })
}

window.rechazarCierre = function(cierre_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de Rechazar el cierre?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Rechazar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/cierre-subasta" +  "/rechazar/" + cierre_id;
                let data = {
                    cierre_id: cierre_id
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
                            loadCierres();
                           
                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha Rechazado el cierre correctamente'
                            });
                            // document.location.reload(true)
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar aprobar el registro!'
                        })
                    }
                });
            }
        })
}

window.ConfirmarRecepcion = function (cierre_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de Confirmar la recepción?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Confirmar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/cierre-subasta" +  "/confirmarRecepcion/" + cierre_id;
                let data = {
                    cierre_id: cierre_id
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
                            loadCierres();
                           
                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha Confirmado la Recepción correctamente'
                            });
                            // document.location.reload(true)
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar confirmar la recepción!'
                        })
                    }
                });
            }
        })
}

window.limpiarModalSubastador = function()
{
    $('#ModalDataTitle').html("")
    $('#lblNombre').html("")
    $('#lblApellidos').html("")
    $('#lblEmail').html("")
    $('#lblTeléfono').html("")
    $('#lblDirección').html("")
    $('#lblUsuario').html("")
}

window.mostrarDataSubastador = function(subastador_id)
{
    limpiarModalSubastador();
    url=$('meta[name=app-url]').attr("content") + "/user/cierre-subasta" + "/getdatauser/" + subastador_id;
    $("#ModalDataSubastador").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('#ModalDataTitle').html('Datos del Subastador')
        $('#lblNombre').html(data.nombres)
        $('#lblApellidos').html(data.apellidos)
        $('#lblEmail').html(data.email)
        $('#lblTeléfono').html(data.telefono)
        $('#lblDirección').html(data.direccion)
        $('#lblUsuario').html(data.usuario)
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.mostrarDataGanador = function (ganador_id)
{
    limpiarModalSubastador();
    url=$('meta[name=app-url]').attr("content") + "/user/cierre-subasta" + "/getdatauser/" + ganador_id;
    $("#ModalDataSubastador").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('#ModalDataTitle').html('Datos del Ganador')
        $('#lblNombre').html(data.nombres)
        $('#lblApellidos').html(data.apellidos)
        $('#lblEmail').html(data.email)
        $('#lblTeléfono').html(data.telefono)
        $('#lblDirección').html(data.direccion)
        $('#lblUsuario').html(data.usuario)
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

