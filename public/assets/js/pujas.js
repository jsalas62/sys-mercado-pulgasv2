function laodpujas(page)
{
    let url='';
    let pujaEstado = $('#estadoPujaBuscar').val();
    url=$('meta[name=app-url]').attr("content")  + "/user" + "/pujas?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {estado: pujaEstado}
    }).done(function (data) {
        $('.pujas').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#estadoPujaBuscar').on('change', function (e ){
    url=$('meta[name=app-url]').attr("content") + "/user" + "/pujas";
    $.ajax({
        url: url,
        method:'GET',
        data: {estado: this.value}
    }).done(function (data) {
        $('.pujas').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
})



window.limpiarModalComprobante = function() {
    $('#imgComprobante').attr('src',"");
}

window.MostrarComprobante = function(comprobante)
{
    // console.log(comprobante);
    $("#ModalComprobante").modal('show');
    $('#imgComprobante').attr('src', comprobante);
}

window.confirmarRecepcionPuja = function(puja_id)
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
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/pujas" +  "/confirmarPujaRecepcion/" + puja_id;
                let data = {
                    puja_id: puja_id
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
                            laodpujas();
                           
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

window.LimpiarSubastadorModal = function()
{
    $('#ModalTitleData').html("")
    $('#lblNSubastador').html("")
    $('#lblASubastador').html("")
    $('#lblESubastador').html("")
    $('#lblTSubastador').html("")
    $('#lblDSubastador').html("")
    $('#lblUSubastador').html("")
}

window.showSubastador = function(subastador_id)
{
    LimpiarSubastadorModal();
    url=$('meta[name=app-url]').attr("content") + "/user/cierre-subasta" + "/getdatauser/" + subastador_id;
    $("#ModalSubastadorData").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('#ModalTitleData').html('Datos del Subastador')
        $('#lblNSubastador').html(data.nombres)
        $('#lblASubastador').html(data.apellidos)
        $('#lblESubastador').html(data.email)
        $('#lblTSubastador').html(data.telefono)
        $('#lblDSubastador').html(data.direccion)
        $('#lblUSubastador').html(data.usuario)
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}
