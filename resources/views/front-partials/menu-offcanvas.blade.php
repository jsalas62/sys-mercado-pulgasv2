
<div class="offcanvas offcanvas-start" tabindex="-1" id="MenuCanvas" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="offcanvasExampleLabel" style="color:#8716f2;">Menú Principal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <form action="{{ url('productos/') }}" class="menuCanvas_search" method="get">
            <div class="input-group">
                <input class="form-control header-search" type="search" name="q" value="" placeholder="Buscar Producto" aria-label="Search" autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-search-mobile" type="submit">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
        <ul class="canvasMenu mt-2">
        @isset($categorias)
            @if(count($categorias)>0)
                @foreach($categorias as $cat)
                    <li>
                        <a href="{{url('categorias/'.$cat['url'])}}">{{$cat->categoria}}</a>
                    </li>
                @endforeach
            @endif
        @endisset
        </ul>
    </div>
  </div>
</div>