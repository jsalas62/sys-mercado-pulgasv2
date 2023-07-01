
$(document).ready(function() {

    console.log('ready');

    $(window).on('hashchange',function(){
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else{
                loadcategorias(page);
            }
        }
    });

    $(document).on('click', '.categorias .pagination a', function(event){
        event.preventDefault();
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadcategorias(page);
    });

    function loadcategorias(page)
    {
        let url='';
        let categoria = $('#txtBuscarCategoria').val();
        let estado = $('#estadoCategoriaBuscar').val(); 
        url=$('meta[name=app-url]').attr("content")  + "/user" + "/categorias?page="+page;

        $.ajax({
            url: url,
            method:'GET',
            data: {categoria: categoria, estado: estado}
        }).done(function (data) {
            $('.categorias').html(data);
        }).fail(function () {
            console.log("Failed to load data!");
        });
    }

    $('#txtBuscarCategoria').on('keyup', function(e){
        url=$('meta[name=app-url]').attr("content") + "/user" + "/categorias";
        let estadocategoria = $('#estadoCategoriaBuscar').val(); 
        $.ajax({
            url: url,
            method:'GET',
            data: {categoria: this.value, estado: estadocategoria}
        }).done(function (data) {
            $('.categorias').html(data);
        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    })

    $('#estadoCategoriaBuscar').on('change', function (e ){
        url=$('meta[name=app-url]').attr("content") + "/user" + "/categorias";
        let categoriabuscar = $('#txtBuscarCategoria').val();
        $.ajax({
            url: url,
            method:'GET',
            data: {categoria: categoriabuscar, estado: this.value}
        }).done(function (data) {
            $('.categorias').html(data);
        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    })

    window.limpiarModalCategoria = function() {
        $('#tituloModalCategoria').html('AGREGAR CATEGORÍA');
        $('#hddcategoria_id').val("");
        $('#txtCategoria').val("");
        $('#txtDescripcionCategoria').val("");
        $('#chkEstadoCategoria').prop('checked', true);
        $('#slug_actual').val("");
    }

    $('#formCategoria').submit(function(event){
        event.preventDefault();
        let hddcategoria_id = $('#hddcategoria_id').val();
        if(hddcategoria_id!="")
        {
            ActualizarCategoria(hddcategoria_id);
        }
        else 
        {
            GuardarCategoria();
        }
    });

    window.GuardarCategoria = function()
    {

            $("#btnGuardarCategoria").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/user" + "/categorias";
            
            let data = {
                categoria: $("#txtCategoria").val(),
                descripcion: $("#txtDescripcionCategoria").val(),
                activo: $('#chkEstadoCategoria').prop('checked'),
            };
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#btnGuardarCategoria").prop('disabled', false);
                    if(response.code == "200")
                    {
                        
                            $("#ModalCategoria").modal('hide');
                            loadcategorias();
                            limpiarModalCategoria();
                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha registrado la Categoría correctamente'
                            });
                    }
                    else  if(response.code == "422")
                    {
                            let errors = response.errors;
                            console.log(errors);
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
                    else if(response.code=="426")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'La categoría ya Existe!'
                            });
                    }
                    else 
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Ha ocurrido un error al intentar registrar la categoría!'
                            });
                    }
                }
            })

    }

    window.mostrarCategoría = function(categoria_id)
    {
        url=$('meta[name=app-url]').attr("content") + "/user" + "/categorias/" +categoria_id;
        $("#ModalCategoria").modal('show');
        $.ajax({
            url: url,
            method:'GET'
        }).done(function (data) {
            $('#tituloModalCategoria').html('EDITAR CATEGORÍA: ' +data.categoria);
            $('#hddcategoria_id').val(categoria_id);
            $('#txtCategoria').val(data.categoria);
            $('#txtDescripcionCategoria').val(data.descripcion);
            $('#slug_actual').val(data.url);
            if(data.estado == "1")
            {
                $('#chkEstadoCategoria').prop('checked', true)
            }
            else 
            {
                $('#chkEstadoCategoria').prop('checked', false)
            }
        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    }

    window.ActualizarCategoria = function(categoria_id)
    {
        $("#btnGuardarCategoria").prop('disabled', true);
        let url = $('meta[name=app-url]').attr("content") +  "/user" + "/categorias/" + categoria_id;
        let data = {
            categoria_id: categoria_id,
            categoria: $("#txtCategoria").val(),
            descripcion: $("#txtDescripcionCategoria").val(),
            activo: $('#chkEstadoCategoria').prop('checked'),
            slug_actual: $('#slug_actual').val(),
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "PUT",
            data: data,
            success: function(response) {
                $("#btnGuardarCategoria").prop('disabled', false);
                if(response.code == "200")
                {
                        limpiarModalCategoria();
                        $("#ModalCategoria").modal('hide');
                        loadcategorias();

                        Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha actualizado la Categoría correctamente'
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
                else if(response.code=="427")
                {
                    Swal.fire({
                            icon: 'error',
                            title: 'ERROR!',
                            text: 'La categoría ya Existe!'
                        });
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
    };

    window.eliminarCategoría = function(categoria_id)
    {
        Swal.fire({
            icon: 'warning',
            title: 'Está seguro de eliminar la categoría?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Eliminar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/categorias/"  + categoria_id;
                    let data = {
                        categoria_id: categoria_id
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
                                loadcategorias();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha eliminado la categoría correctamente'
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

    window.desactivarCategoría = function(categoria_id)
    {
        Swal.fire({
            icon: 'warning',
            title: 'Está seguro de desactivar la Categoría?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Desactivar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/categorias" +  "/desactivar/" + categoria_id;
                    let data = {
                        categoria_id: categoria_id
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
                                loadcategorias();
                               
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha desactivado la Categoría correctamente'
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

    window.activarCategoria = function(categoria_id)
    {
        Swal.fire({
            icon: 'warning',
            title: 'Está seguro de activar la Categoría?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Activar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/categorias" +  "/activar/" + categoria_id;
                    let data = {
                        categoria_id: categoria_id
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
                                loadcategorias();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha activado la categoría correctamente'
                                });
                                // document.location.reload(true)
                            }
                        },
                        error: function(response) {                    
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Se ha producido un error al intentar activar el registro!'
                            })
                        }
                    });
                }
            })
    }

});