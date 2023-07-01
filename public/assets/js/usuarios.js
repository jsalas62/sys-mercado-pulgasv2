
$(window).on('hashchange',function(){
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else{
            loadusuarios(page);
        }
    }
});

$(document).on('click', '.tbl-usuarios .pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // console.log(page);
        loadusuarios(page);
});

function loadusuarios(page)
{
    let url='';
    let txtusuariobuscar = $('#txtBuscarUsuario').val();
    let estado = $('#estadoUsuarioBuscar').val(); 

    url=$('meta[name=app-url]').attr("content")  + "/user" + "/usuarios?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {usuario: txtusuariobuscar,estado: estado}
    }).done(function (data) {
        $('.tbl-usuarios').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#txtBuscarUsuario').on('keyup', function(e){
    let usuario = this.value;
    let estadousuario = $('#estadoUsuarioBuscar').val();
    ajaxloadusuarios(usuario, estadousuario);
})

$('#estadoUsuarioBuscar').on('change', function(e){
    let usuario = $('#txtBuscarUsuario').val();
    let estadousuario = this.value;
    ajaxloadusuarios(usuario, estadousuario);
})

function ajaxloadusuarios(usuario, estado)
{
    const url=$('meta[name=app-url]').attr("content") + "/user" + "/usuarios";
    $.ajax({
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method:'GET',
        data: {usuario: usuario,estado: estado}
    }).done(function (data) {
        $('.tbl-usuarios').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.eliminarUsuario = function(user_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de eliminar el Usuario?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios/"  + user_id;
                let data = {
                    user_id: user_id
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
                            loadusuarios();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha eliminado el usuario correctamente'
                            });
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

window.desactivarUsuario = function(user_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de desactivar el Usuario?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Desactivar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios" +  "/desactivar/" + user_id;
                    let data = {
                        user_id: user_id
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
                                loadusuarios();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha desactivado el Usuario correctamente'
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

window.activarUsuario = function(user_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de activar el Usuario?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Activar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios" +  "/activar/" + user_id;
                    let data = {
                        user_id: user_id
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
                                loadusuarios();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha activado el Usuario correctamente'
                                });

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