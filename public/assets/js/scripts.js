// script as-template 

$(document).ready(function () {

    console.log('Listo');


    function getRandomInt(t) {
        return Math.floor(Math.random() * t)
    }

     home_slider();

     $(document).on('click', '.btnpuja', function(){
        $(this).prop('disabled', true);
        let url = $('meta[name=app-url]').attr("content")+ "/store-puja";
        let data = {
            user: $("#user").val(),
            subasta: $('#skey').val(),
            puja: $('#PujaF').val()
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                $('.btnpuja').prop('disabled', false);
                if(response.code == 200)
                {
                   $('#PujaF').val("");
                   $('#puja_actual').html("");
                   $('#puja_actual').html('S/. ' + response.maxValueSubasta);
                   Swal.fire({
                        icon: 'success',
                        title: 'ÉXITO!',
                        text: 'Se ha registrado la Puja correctamente'
                    });
                }
                else  if(response.code == "426")
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'Ingrese un monto mayor a la puja actual!'
                    });
                }
                else 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'Se ha producido un error al registrar la Puja!'
                    });
                }
            }
        })
        
    })

    //  if($("#btnpuja").length > 0){
        
    //     $('.btnpuja').click(function(event){
    //         event.preventDefault();
    //         console.log('gaaa');
    //     })
    //  }

});



function home_slider(){
    $('.slider-main').slick({
       dots: false,
       infinite: true,
       slidesToShow: 1,
       slidesToScroll: 1,
       fade: true,
       arrows: true,
       autoplay: true,
       autoplaySpeed: 4000,
       lazyLoad: 'ondemand'
     });
 }
