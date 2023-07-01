$(document).ready(function () {

    // addCartClick();

    function loadcarrito()
    {
        url=$('meta[name=app-url]').attr("content")  + "/load-cart";

        $.ajax({
            url: url,
            method:'GET'
        }).done(function (data) {
            $('#ModalCart .modal-content').html(data);
        }).fail(function () {
            console.log("Failed to load data!");
        });
    }

    function loadtablepago()
    {
        url=$('meta[name=app-url]').attr("content")  + "/load-table-pago";

        $.ajax({
            url: url,
            method:'GET'
        }).done(function (data) {
            $('.resumen-pedido').html(data);
        }).fail(function () {
            console.log("Failed to load data!");
        });
    }

    // function addCartClick()
    // {
        $(document).on('click', '.btnComprarCart', function(){
        // $('.btnComprarCart').on('click', function() {
            $(this).prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content")+ "/add-cart";
            let data = {
                cantidad: $("#pcantidad").val(),
                producto_id: $('#pkey').val(),
                producto_imagen: $('#producto_imagen').val()
            }
    
            $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $('.btnComprarCart').prop('disabled', false);
                    if(response.code == 200)
                    {
                        loadcarrito();
                        $('#CartCount').html(response.nroproductos);
                        $('#ModalCart').modal('show'); 
                    }
                    else 
                    {
                        
                    }
                }
            })
    
        });
    // }
  

    window.UpdateItemCart = function(item, i)
    {
        let url = $('meta[name=app-url]').attr("content")+ "/update-cart";
        let quantity = $('#Quantity'+i).val();
        let data  = {
            id_edit: item,
            quantity: quantity
        }
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                if(response.code == 200)
                {
                    loadcarrito();
                    if(document.getElementById('table-pago')!==null){
                        loadtablepago();
                    }
                }
                else
                {

                }
            }
        })
    }

    window.UpdateItemCartTablePago = function(item, i)
    {
        let url = $('meta[name=app-url]').attr("content")+ "/update-cart";
        let quantity = $('#qtyTablePago'+i).val();
        let data  = {
            id_edit: item,
            quantity: quantity
        }
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                if(response.code == 200)
                {
                        loadcarrito();
                    if(document.getElementById('table-pago')!==null){
                        loadtablepago();
                    }
                }
                else
                {

                }
            }
        })
    }
    
    window.RemoveItemCart = function(id_remove)
    {
        let url = $('meta[name=app-url]').attr("content")+ "/remove-cart";
        let coupon = $('#txtcoupon').val();
        let data  = {
            id_remove: id_remove,
            coupon : coupon
        }
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                // console.log(response);
                if(response.code == 200)
                {
                    loadcarrito();
                    $('#CartCount').html(response.nroproductos);
                    if(document.getElementById('table-pago')!==null){
                    loadtablepago();
                    }

                    if(document.getElementById('totalval')!==null){

                        let totalvalue = response.moneda +  parseFloat(response.totalval).toFixed(2); 
                        $('#totalval').html(totalvalue);
                    }
                }
                else
                {

                }
            }
        })
    }

    window.CuponValue = function()
    {
        let coupon = $('#txtcoupon').val();
        let url = $('meta[name=app-url]').attr("content")+ "/cupones";
        let data  = {
            coupon: coupon
        }
        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                console.log(response);
                if(response.code == 200)
                {
                    if(document.getElementById('table-pago')!==null){
                        loadtablepago();
                    }

                    if(document.getElementById('totalval')!==null){

                        let totalval = response.moneda +  parseFloat(response.total).toFixed(2); 
                        $('#totalval').html(totalval);
                    }
                }
                else
                {

                }
            }
        })
    }

    
    // $(document).on('click','.btnRemoveProductCart', function(){
    //     let url = $('meta[name=app-url]').attr("content")+ "/remove-cart";
    //     let data  = {
    //         id_remove: $('#id_remove').val()
    //     }
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: url,
    //         type: "POST",
    //         data: data,
    //         success: function(response) {
    //             if(response.code == 200)
    //             {
    //                 loadcarrito();
    //                 $('#CartCount').html(response.nroproductos);
    //             }
    //             else
    //             {

    //             }
    //         }
    //     })
    // });
});