//proceso para generar ID de manera aleatoria
const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

function generateString(length) {
    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function loadimage(url,preview,nameval,del_icon,nombre,image_id,size,attrid,temporal,title='')
{
    let nameinput =nameval+image_id;
    // $('#'+input+'').val(url);
    // $('#'+preview+'').removeAttr('hidden');
    let urlImage = $('meta[name=app-url]').attr("content") + "/" + url;
    $('#'+preview+'').append("<div class='img-div col-12' id='"+nameinput+"'>" +
        // "<img src='"+urlImgBanner+"' class='img-fluid image img-thumbnail' title='"+title+image_id+"'>"+
        "<img src='"+urlImage+"' class='img-fluid image img-thumbnail' title='"+nombre+"'>"+
        "<div class='middle'>"+
        "<button type='button' id='"+del_icon+"-icon' value='"+nameinput+"' class='btn btn-danger' name='"+nombre+"' temporal='"+temporal+"' "+attrid+"='"+image_id+"'>"+
            "<i class='fa fa-trash'></i>"+
        "</button>"+
        "&nbsp;&nbsp;"+
        "<a class='btn btn-info' download href='"+urlImage+"'><i class='fas fa-download'></i></a>"+
        "</div>"+
        "<input value='"+nombre+"|*|"+size+"|*|"+temporal+"' name='"+nameval+"' id='"+nameval+"' type='hidden'>" +
        "</div>");
}

function previewtmpimage_col3(url, preview, id, name, size, namevalue, delbtn, attr)
{
    $('#'+preview+'').append("<div class='img-div col-md-3 col-6' id='"+id+"'>" +
    "<img src='"+url+"' class='img-fluid image img-thumbnail' title='"+name+"'>"+
    "<div class='middle'>"+
    "<button type='button' id='"+delbtn+"-icon' value='"+id+"' class='btn btn-danger' name='"+name+"' temporal='1' "+attr+"='' image_id=''>"+
        "<i class='fa fa-trash'></i>"+
    "</button>"+
    "</div>"+
    "<input value='"+name+"|*|"+size+"|*|1' name='"+namevalue+"' id='"+namevalue+"' type='hidden'>" +
    "</div>");
}

function previewtmpimage_col12(url, preview, id, name, size, namevalue, delbtn, attr)
{
    $('#'+preview+'').append("<div class='img-div col-12' id='"+id+"'>" +
    "<img src='"+url+"' class='img-fluid image img-thumbnail' title='"+name+"'>"+
    "<div class='middle'>"+
    "<button type='button' id='"+delbtn+"-icon' value='"+id+"' class='btn btn-danger' name='"+name+"' temporal='1' "+attr+"='' image_id=''>"+
        "<i class='fa fa-trash'></i>"+
    "</button>"+
    "</div>"+
    "<input value='"+name+"|*|"+size+"|*|1' name='"+namevalue+"' id='"+namevalue+"' type='hidden'>" +
    "</div>");
}

function deleteTempImg(div, file, temporal, url)
{
    let dataForm = new FormData();
    dataForm.append("filename",file);
    $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: dataForm,
            processData: false,  
            contentType: false,  
            success: function(response) {
                if(response.code=='200')
                {
                    $(`#${div}`).remove();
                }
                else 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar elminar el archivo!'
                    })
                }
            }
    });
}

function deleteImg(div, file, image_id, temporal, url, superpuesto = 0, id = 0)
{
    let dataForm = new FormData();
    dataForm.append("filename",file);
    dataForm.append("image_id",image_id);
    dataForm.append("temporal",temporal);
    dataForm.append("superpuesto",superpuesto);
    dataForm.append("id",id);
    $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: dataForm,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function(response) {
                if(response.code=='200')
                {
                    $(`#${div}`).remove();
                }
                else 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar elminar el archivo!'
                    })
                }
            }
    });
}

function deleteImgproducto(div,file, producto_id, img_id)
{
    let url = $('meta[name=app-url]').attr("content") +  "/admin" + "/productos/eliminarImagen";
    let formDataFi = new FormData();
    formDataFi.append("filename",file);
    formDataFi.append("producto_id",producto_id);
    formDataFi.append("image_id",img_id);
    $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: formDataFi,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function(response) {
                if(response.code=='200')
                {
                    $(`#${div}`).remove();
                }
                else 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar elminar el archivo!'
                    })
                }
            }
    });
}

function deleteimgGaleria(div,file, data_id, img_id, url)
{
    let formDataImg = new FormData();
    formDataImg.append("filename",file);
    formDataImg.append("data_id",data_id);
    formDataImg.append("image_id",img_id);
    $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: formDataImg,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function(response) {
                if(response.code=='200')
                {
                    $(`#${div}`).remove();
                }
                else 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar elminar el archivo!'
                    })
                }
            }
    });
}

function empty(e)
{
    switch (e) {
        case "":
            return true;
        case 0:
            return true;
        case "0":
            return true;
        case null:
            return true;
        case undefined:
          return true;
        default:
          return false;
    }
}
