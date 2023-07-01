$('#fotoDataUser').change(function(){   
    let foto = $('input[name="fotoDataUser"]')[0].files;
    let url = $('meta[name=app-url]').attr("content") +  "/user" + "/usuarios/subirImagenTmp";
    let fotoData = new FormData();
    let id = generateString(3);
    fotoData.append("imagen",foto[0]);
    fotoData.append("indice",1);
    $('#fotoDataUsuario_preview').html("");
    $("#guardarDataUser").prop('disabled', true);
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
            $("#guardarDataUser").prop('disabled', false);
            if(response.code==200)
            {
                let urlraiz = $('meta[name=app-url]').attr("content") + "/";
                let urlimage = urlraiz + response.data.url;
                let img_id = 'fotoDataUser' + id;
                previewtmpimage_col12(urlimage, 'fotoDataUsuario_preview',img_id, response.data.name, response.data.size, 'fotodatausuario', 'fotodata-action', 'fotodata_id');
                document.getElementById('fotoDataUser').value="";
            }
            else  if(response.code == "422")
            {
                document.getElementById('fotoDataUser').value="";
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
                document.getElementById('fotoDataUser').value="";

                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'Se ha producido un error al intentar actualizar el registro!'
                })
            }
        },
        error: function(response) {
            document.getElementById('fotoDataUser').value="";
            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar actualizar el registro!'
            })
        }
    });
});

$('body').on('click', '#fotodata-action-icon', function(evt){
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
        $('#fotoDataActualUsuario').val("");
    }
    
    evt.preventDefault();
});

$('#guardarDataUser').click(function(event){
    event.preventDefault();
    let hddusuario_id = $('#hdddatausuario_id').val();
    if(hddusuario_id!="")
    {
        guardardataUsuario(hddusuario_id);
    }
});

window.guardardataUsuario = function(hddusuario_id){
    $("#guardarDataUser").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") + "/user/misdatos";
    let formData = new FormData($("#formDataUser")[0]); 
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
            $("#guardarDataUser").prop('disabled', false);
            if(response.code == "200")
            {   
                // location.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se ha actualizado los datos correctamente',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
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
            $("#guardarDataUser").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            })
        }
    });
}