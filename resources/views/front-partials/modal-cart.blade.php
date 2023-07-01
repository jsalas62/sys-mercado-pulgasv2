<!-- Modal -->
<div class="modal right fade" id="ModalCart" tabindex="-1" aria-labelledby="ModalCart" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title font-weight-bold">CARRITO</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="divCartEmpty">
                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                <p>Tú Carro esta vacío</p>
                <button class="btn btn-primary rounded-btn btn-cart-modal-close" style="width:50%;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        @include('front-partials.cart-data')

        </div>
    </div>
</div>
<!-- modal -->