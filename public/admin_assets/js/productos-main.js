$(window).on('hashchange',function(){
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else{
            loadproductos(page);
        }
    }
});


$(document).on('click', '.productos .pagination a', function(event){
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    // console.log(page);
    loadproductos(page);
});


function loadproductos(page)
{
    let url='';
    let txtproduto = $('#txtBuscarProduto').val();
    let cboCategoriaProducto = $('#BuscarCategoriaProducto').val();
    let estado = $('#estadoProductoBuscar').val(); 
    url=$('meta[name=app-url]').attr("content")  + "/admin" + "/productos?page="+page;

    $.ajax({
        url: url,
        method:'GET',
        data: {producto: txtproduto,categoria: cboCategoriaProducto,estado: estado}
    }).done(function (data) {
        $('.productos').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$('#txtBuscarProduto').on('keyup', function(e){

    let producto = this.value;
    let categoriaproducto = $('#BuscarCategoriaProducto').val();
    let estadoproducto = $('#estadoProductoBuscar').val();
    ajaxloadproductos(producto, categoriaproducto, estadoproducto);
})

$('#BuscarCategoriaProducto').on('change', function (e ){
  
    let producto2 = $('#txtBuscarProduto').val();
    let categoriaproducto2 = this.value;
    let estadoproducto2 = $('#estadoProductoBuscar').val();
    ajaxloadproductos(producto2, categoriaproducto2, estadoproducto2);
});

$('#estadoProductoBuscar').on('change', function(e){

    let producto3 = $('#txtBuscarProduto').val();
   let categoriaproducto3 = $('#BuscarCategoriaProducto').val();
    let estadoproducto3 = this.value;
    ajaxloadproductos(producto3, categoriaproducto3, estadoproducto3);
})

function ajaxloadproductos(producto, categoria, estado)
{
    const url=$('meta[name=app-url]').attr("content") + "/admin" + "/productos";
    $.ajax({
        headers: 
        {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method:'GET',
        data: {producto: producto,categoria: categoria,estado: estado}
    }).done(function (data) {
        $('.productos').html(data);
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.eliminarProducto = function(producto_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de eliminar el Producto?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/admin" + "/productos/"  + producto_id;
                let data = {
                    producto_id: producto_id
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
                            loadproductos();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha eliminado el producto correctamente'
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

window.desactivarProducto = function(producto_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de desactivar el Producto?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Desactivar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/admin" + "/productos" +  "/desactivar/" + producto_id;
                    let data = {
                        producto_id: producto_id
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
                                loadproductos();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha desactivado el Producto correctamente'
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

window.activarProducto = function(producto_id)
{
    Swal.fire({
            icon: 'warning',
            title: 'Está seguro de activar el Producto?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#EB1010",
            confirmButtonText: `Activar`,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = $('meta[name=app-url]').attr("content") +  "/admin" + "/productos" +  "/activar/" + producto_id;
                    let data = {
                        producto_id: producto_id
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
                                loadproductos();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha activado el Producto correctamente'
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
