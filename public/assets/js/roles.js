$(window).on('hashchange',function(){
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else{
            loadroles(page);
        }
    }
});

$(document).on('click', '.tbl-roles .pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // console.log(page);
        loadroles(page);
});

function loadroles(page)
{
    let url='';
    let rolbuscar = $('#txtBuscarRol').val();
    let estadorolbuscar = $('#estadoRolBuscar').val(); 

    url=$('meta[name=app-url]').attr("content")  + "/user" + "/roles?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {rol: rolbuscar,estado: estadorolbuscar}
    }).done(function (data) {
        $('.tbl-roles').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#txtBuscarRol').on('keyup', function(e){
    let rol = this.value;
    let estadorol = $('#estadoRolBuscar').val();
    ajaxloadroles(rol, estadorol);
})

$('#estadoRolBuscar').on('change', function(e){
    let rol = $('#txtBuscarRol').val();
    let estadorol = this.value;
    ajaxloadroles(rol, estadorol);
})

function ajaxloadroles(rol, estado)
{
    const url=$('meta[name=app-url]').attr("content") + "/user" + "/roles";
    $.ajax({
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method:'GET',
        data: {rol: rol,estado: estado}
    }).done(function (data) {
        $('.tbl-roles').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.eliminarRol = function(rol_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de eliminar el Rol?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/user" + "/roles/"  + rol_id;
                let data = {
                    id: rol_id
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
                            loadroles();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha eliminado el Rol correctamente'
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

window.desactivarRol = function(rol_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de desactivar el Rol?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Desactivar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/roles" +  "/desactivar/" + rol_id;
                    let data = {
                        rol_id: rol_id
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
                                loadroles();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha desactivado el Rol correctamente'
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

window.activarRol = function(rol_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de activar el Rol?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Activar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/roles" +  "/activar/" + rol_id;
                    let data = {
                        rol_id: rol_id
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
                                loadroles();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha activado el Rol correctamente'
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