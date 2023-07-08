@extends('master')

@section('content')

<div class="container-fluid container-xxl">

    <div class="slider-main">

        <div class="slider-item">
            <img class="img-fluid d-block w-100" src="{{asset('assets/images/slider1.webp')}}" title="Slider" width="40">
        </div>

        <div class="slider-item">
            <img class="img-fluid d-block w-100" src="{{asset('assets/images/slider2.jpg')}}" title="Slider">
        </div>

        <div class="slider-item">
            <img class="img-fluid d-block w-100" src="{{asset('assets/images/slider3.jpg')}}" title="Slider">
        </div>

    </div>

    @isset($productos)

    <div class="title-bloque">
        <h2>Subastas de Productos</h2>
    </div>

    <div class="mt-4" style="overflow:hidden">

        <div class="row pb-15" style="padding-left:2px;">

            @if(count($subastas) > 0)

                @foreach($subastas as $subasta)
                    <?php $encryptProduct=Hashids::encode($subasta['subasta_id']);?>  
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="box-producto h-100 d-flex flex-column">

                            <div class="product-image">

                                <a href="{{ url('producto/'.$subasta['url']) }}" class="text-decoration-none">

                                    <!-- Imagen Producto -->
                                    <img class="img-fluid" data-src="{{asset($subasta['imagen'])}}" src="{{asset($subasta['imagen'])}}" alt="Imagen Producto" title="{{$subasta['producto']}}">
                                    <!-- Fin Imagen Producto -->
                                </a>

                            </div>

                            <div class="box-title mb-1">
                                <a href="{{ url('producto/'.$subasta['url']) }}" class="grid-box-producto-nombre mt-auto" title="{{$subasta['producto']}}">
                                    <h3 class="box-producto-title">{{$subasta['producto']}}</h3>
                                </a>
                            </div>

                            <div class="box-details text-center mt-auto">
                                <div class="text-center box-price">
                                    @if($subasta['precio_min']!= '0.00')
                                        <div class="price">S/. {{$subasta['precio_min']}}</div>
                                    @endif
                                </div>

                                <div class="text-center" style="padding: 0 2px !important;">
                                    <a href="{{ url('producto/'.$subasta['url']) }}" class="btn btn-default btn-pri br-32 w-100" type="button" tabindex="0"><i class="fas fa-eye"></i> Ver</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            @endif

        </div>
    </div>

    @endisset

    <section class="mp-footer_top mt-3" style="background:#e9dbeb;">
        <div class="row justify-content-center py-5">
            <div class="col-md-auto col-lg-8">
                <h5 class="mp-footer_top-title text-center mb-4">Nuestra Tienda</h5>
                <p class="mp-footer_top-info">📍Calle Roma 324 - San Isidro (Tocar la puerta, no hay timbre). De Lunes a Sábado 🕑 9:30AM a 6:30PM</p>
                <div class="d-flex justify-content-center">
                    <a href="https://maps.google.com?daddr=C. Roma 324, San Isidro 15076" target="_blank" class="btn btn-default btn-ubicacion bradius text-center mt-3" type="button">
                    <i class="fas fa-map-marker" aria-hidden="true"></i> &nbsp;COMO LLEGAR A LA TIENDA
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>



@endsection