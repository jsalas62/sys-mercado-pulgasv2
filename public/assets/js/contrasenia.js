window.limpiarInputs = function()
{
    $('#passActualUsuario').val("");
    $('#passNuevaUsuario').val("");
    $('#passRepetirUsuario').val("");
}

$('#guardarPassUser').click(function(event){
    event.preventDefault();
    let hddusuario_id = $('#hdddatausuario_id').val();
    if(hddusuario_id!="")
    {
        guardarNewPass(hddusuario_id);
    }
});

window.guardarNewPass = function(hddusuario_id){
    $("#guardarPassUser").prop('disabled', true);
    let url = $('meta[name=app-url]').attr("content") + "/user/contrasenia";
    let formData = new FormData($("#formPassUser")[0]); 
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
            $("#guardarPassUser").prop('disabled', false);
            if(response.code == "200")
            {   
                limpiarInputs();
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se han actualizado los datos correctamente'
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

            else  if(response.code == "423")
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'La contraseña es incorrecta!'
                })
            }
        },
        error: function(response) {
            $("#guardarPassUser").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            })
        }
    });
}