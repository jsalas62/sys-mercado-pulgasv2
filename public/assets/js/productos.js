$('#imgProducto').change(function(){
        
    let img = $('input[name="imgProducto"]')[0].files;
    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/productos/subirImagenTmp";
    let imgDataprincipal = new FormData();
    let id = generateString(3);
    imgDataprincipal.append("imagen",img[0]);
    imgDataprincipal.append("indice",1);
    $('#imgProducto_preview').html("");
    $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: imgDataprincipal,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function(response) {
                if(response.code==200)
                {
                    let urlraiz = $('meta[name=app-url]').attr("content") + "/";
                    let urlimage = urlraiz + response.data.url;
                    let img_id = 'imgprincipal' + id;
                    previewtmpimage_col3(urlimage, 'imgProducto_preview',img_id, response.data.name, response.data.size, 'imgproducto', 'imagen-action', 'producto_id');
                    document.getElementById('imgProducto').value="";
                }
                else  if(response.code == "422")
                {
                    document.getElementById('imgProducto').value="";
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
                    document.getElementById('imgProducto').value="";

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            },
            error: function(response) {
                document.getElementById('imgProducto').value="";
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'Se ha producido un error al intentar actualizar el registro!'
                })
            }
    });
})

$('body').on('click', '#imagen-action-icon', function(evt){
    let divNameImg = this.value;
    let filenameImg = $(this).attr('name');
    let temporalImg = $(this).attr('temporal');
    let producto_id  = $(this).attr('producto_id');
    let image_id = 0;

    if(temporalImg == 1)
    {
        let url = $('meta[name=app-url]').attr("content") +  "/user" + "/productos/eliminarImagenTmp";
        deleteTempImg(divNameImg, filenameImg, temporalImg, url);
    }
    else if(temporalImg == 0)
    {
        let url = $('meta[name=app-url]').attr("content") +  "/user" + "/productos/eliminarImagen";
        // deleteimg(divNameImg, filenameImg, producto_id, image_id);
        deleteImgproducto(divNameImg, filenameImg, producto_id, image_id);
        $('#idImgProducto').val("");
    }
    
    evt.preventDefault();
});


$('#guardarProducto').click(function(event){
    event.preventDefault();
    let hddproducto_id = $('#hddproducto_id').val();
    if(hddproducto_id!="")
    {
        actualizarProducto(hddproducto_id);
    }
    else 
    {
        guardarProducto();
    }
});

window.guardarProducto = function(){

    $("#guardarProducto").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") + "/user/productos";
    let formData = new FormData($("#formProducto")[0]); 
    formData.append("descripcion_producto",CKEDITOR.instances['txtDescripcionProducto'].getData());
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
            $("#guardarProducto").prop('disabled', false);
            if(response.code == "200")
            {   
                    Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se ha registrado el Producto correctamente',
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
        },
        error: function(response) {
            $("#guardarProducto").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            })
        }
    });
}

window.actualizarProducto = function(producto_id)
{  
    $("#guardarProducto").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") + "/user/productos/" + producto_id;
    let formDataEditar = new FormData($("#formProducto")[0]); 
    formDataEditar.append("descripcion_producto",CKEDITOR.instances['txtDescripcionProducto'].getData());
    formDataEditar.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        enctype: 'multipart/form-data',
        data: formDataEditar,
        processData: false,  
        contentType: false,  
        success: function(response) {
            $("#guardarProducto").prop('disabled', false);
            if(response.code == "200")
            {   
                    Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se ha actualizado el Producto correctamente',
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
        },
        error: function(response) {
            $("#guardarProducto").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            })
        }
    });
}
