<aside class="mp-header-top">

    <div class="container-xxl">
        <div class="d-flex align-items-center justify-content-between">
            <h3 class="header-title">⏳¡¡Anímate a Encontrar tus productos favoritos!!⏳</h3>
             <!-- search -->
             <form action="{{ url('productos/') }}" class="mp-header-top__search" method="get">
                <div class="input-group">
                    <input class="form-control header-search" type="search" name="q" value="" placeholder="Buscar Producto" aria-label="Search" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-search-mobile" type="submit">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</aside>

<header class="mp-header mt-2 mb-4">
    
    <div class="container-xxl">

        <div class="mp-grid-header d-flex align-items-center justify-content-between p-relative">
            
            <button class="btn btn-header d-lg-none order-md-1 order-sm1" type="button" data-bs-toggle="offcanvas" data-bs-target="#MenuCanvas" aria-controls="offcanvasExample">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <!-- Logo -->
            <a class="navbar-brand mp-grid-header__logo me-0 order-lg-1 order-md-2 order-sm-2" href="{{ url('/') }}" title="Mercado de Pulgas">
                <img class="img-fluid" src="{{asset('assets/images/logo22.jpg')}}" alt="Mercado de Pulgas" title="Mercado de Pulgas" style="width: 350px; height: auto; transition: all 0.25s ease 0s;" />
            </a>
            @if(Auth::user())
                <!-- <div class="mp-header-buttons order-lg-2"> -->
                <div class="dropdown order-lg-2 order-md-3 order-sm-3 ">
                    <button class="btn btnlogin as-grid-header__login btn-header dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <h6 class="dropdown-header">{{ Auth::user()->usuario }}</h6>
                        <li><a class="dropdown-item" href="{{ url('/user/account') }}"><i class="fas fa-user-cog"></i> Mi Cuenta</a></li>
                        <li><a class="dropdown-item" href="{{ url('/logout') }}"> <i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            @else 
                <a href="{{ url('/login') }}" role="button" class="btn btnlogin as-grid-header__login btn-header order-lg-2 order-md-3 order-sm-3">
                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                </a>
            @endif

            <!-- <a href="#" role="button" class="btn btncart as-grid-header__cart btn-header order-lg-3 order-md-4 order-sm-4" data-bs-toggle="modal" data-bs-target="#ModalCart">
                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                <span id="CartCount" class="cart-counter counter" data-cart-render="item_count">2</span>
            </a> -->
            
            <!-- </div> -->

        </div>


        <div class="mp-menu mt-3">

            <nav>
                <ul class="main-nav d-flex align-items-center justify-content-center gap-4 py-3">
                    @isset($categorias)
                        @if(count($categorias)>0)
                            @foreach($categorias as $cat)
                                <li class="list-style-none">
                                    <a href="{{url('categorias/'.$cat['url'])}}">{{$cat->categoria}}</a>
                                </li>
                            @endforeach
                        @endif
                    @endisset
                </ul>
            </nav>

        </div>



    </div>

</header>

<div class="cartmodal">

    @include('front-partials.modal-cart')

</div>

@include('front-partials.menu-offcanvas')

