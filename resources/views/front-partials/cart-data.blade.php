@isset($cart_content)
    @if(count($cart_content)>0)
        <div class="modal-header">
            <h3 class="modal-title font-weight-bold">CARRITO</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    @endif
@endisset
            
@isset($cart_content)
    @if(count($cart_content)>0)
        <div class="modal-body">
            <div class="contItemscard">
                @php $c = 1 @endphp
                @foreach($cart_content as $cart)

                    <?php $cartidencrypt=Hashids::encode($cart->id);?>
                    <section class="CardProduct">
                        <div class="containerCardProduct fadeIn">
                            <div class="detailProductCart">
                                <div class="imgProductCart">
                                    <picture>
                                        <img clas="img-fluid" src="{{asset($cart->attributes->image)}}" alt="{{$cart->name}}" title="{{$cart->name}}" />
                                    </picture>
                                </div>
                                <div class="infoProductCart">
                                    <a class="productName" href="{{ url('producto/'.$cart->attributes->url) }}">{{$cart->name}}</a>
                                    <div class="productPrice">
                                        <span class="text-muted">Precio</span>
                                        <span class="money">{{$moneda[0]['prefijo']}} {{number_format((float)$cart->price, 2, '.', '')}}</span>
                                    </div>
                                    
                                </div>
                            
                            </div>

                            <div class="containerButtonsProduct d-flex justify-content-between">
                              
                                <input type="hidden" name="id_edit" value="{{$cart->id}}">
                               
                                <div class="quantityButtons">
                                    
                                    <div class="quantityButtonsText">
                                        <div class="input-group input-group-sm qntgroup">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-secondary rounded-btn btncntd b-minus" id="append-btn-start">
                                                    <i class="fas fa-minus" aria-hidden="true"></i>
                                                </button>
                                            </div>                                    
                                            <input type="text" class="form-control text-center cntdvl" id="Quantity{{$c}}" name="quantity" value="{{$cart->quantity}}" aria-describedby="basic-addon1">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-secondary rounded-btn btncntd b-plus" id="append-btn-end">
                                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>   
                                    </div>
                            
                                </div>

                                <div class="buttonsProduct btn-group">
                                    <button type="button" class="btn btn-dark rounded-btn" title="Actualizar Cantidad" onclick="UpdateItemCart(<?php echo "'".$cartidencrypt."'"; ?>, <?php echo "'".$c."'"; ?>)"><i class="fas fa-edit" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-danger rounded-btn btnRemoveProductCart" title="Eliminar Producto" onclick="RemoveItemCart(<?php echo "'".$cartidencrypt."'"; ?>)"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
                                </div>

                            </div>
                        </div>
                    </section>

                    @php $c++; @endphp
                @endforeach
            </div>
            
            <!--Minicart Popup-->
        </div>

        <div class="modal-footer">

            <div class="divSubtotal">
                <h5>Subtotal: &nbsp;&nbsp;&nbsp;<span class="product-price border-subtotal-style"><span class="money" style="font-weight:300">{{$moneda[0]['prefijo']}} {{number_format((float)$cart_total, 2, '.', '')}}</span></span></h5>
            </div>
            <br>

            <div class="btntotal">
                <button type="button" class="btn btn-dark rounded-btn btn-shopping-style" data-bs-dismiss="modal">Seguir Comprando</button>
                <a href="{{url('pago')}}" class="btn btn-secondary rounded-btn btn-pay-style">Pagar</a>
            </div>
        </div>

    @else 

        <div class="modal-body">
            <div class="divCartEmpty">
                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                <p>Tú Carro esta vacío</p>
                <button class="btn btn-primary rounded-btn btn-cart-modal-close" style="width:50%;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>

    @endif
@endisset