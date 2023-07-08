@extends('master')

@section('content')

    <section class="mp-productos">

        <div class="mp-breadcrumb" aria-label="breadcrumb">
            <nav class="container-xxl">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}" title="E-Shop">Inicio</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                    Producto
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{$subasta['producto']}}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid container-xxl">

            @php 
                $encryptProductoId=Hashids::encode($subasta['subasta_id']); 
            @endphp

            <div class="row">

                <div class="col-md-6 col-12">
                    <div class="row">
                        <section class="col-12">

                                <picture>
                                    <img id="productimage" class="img-fluid" src="{{ asset($subasta['imagen']) }}?w=400"  />    
                                </picture>
                        
                                <!-- </div> -->
                        </section>
                    </div>
                </div>

                <div class="col-md-6 col-12">

                    <article class="mt-3">

                        <h1 class="as-producto_title">{{ $subasta['producto'] }}</h1>

                        <span>Subastado por: <strong>{{$subasta['usuario']}}</strong></span>
                                                                                                            
                        <div class="product-single__description rte mt-3">
                            {!! $subasta['descripcion_producto'] !!}
                        </div>

                        <h4>Categoria:</h4>

                        <ul class="category-products mb-3">
                            <li><a href="{{url('categorias/'.$subasta['categoria_url'])}}">{{$subasta['categoria']}}</a></li>
                        </ul>   

                        <div class="cardprecio">

                            @if($subasta['estado'] == 1)
            
                                <div class="card precios_div pb-3  br-32">

                                        @php
                                            $timestamp = new DateTime(null, new DateTimeZone('America/Lima'));
                                            $nows = $timestamp->format('Y-m-d H:i:s'); 
                                            $dif = strtotime($subasta['tiempo_fin']); 
                                        @endphp
                                
                                        
                                        <div class="text-center precio_subasta">
                                            <div class="Price mt-3">    
                                                <h5>Precio Mínimo de la Subasta:</h5>
                                                <p class="fw-bold" style="font-size: 20px;">S/. {{$subasta['precio_min']}}</p>
                                            </div>

                                            <div class="Price mt-3">    
                                                <h5>Puja Actual:</h5>
                                                @if($subasta['puja_max'])
                                                    <span id="puja_actual" class="fw-bold" style="font-size:15px; color:red">S/. {{$subasta['puja_max']}}</span>
                                                @else 
                                                <span id="puja_actual" class="fw-bold" style="font-size:15px; color:red">S/. 0.00</span>
                                                @endif
                                            </div>
                                            
                                        </div>

                                        @if($nows >= $subasta['tiempo_inicio'])

                                            <div class="product-buttons text-center mb-3">
                                                @if(Auth::user())
                                                    <input type="hidden" id="skey" name="skey" value="<?php echo $encryptProductoId ?>">
                                                    <input type="hidden" id="user" name="user" value="{{Auth::user()->user_id}}">
                                                    <input type="number" name="PujaF" id="PujaF" class="form-control form-custom-input w-50 input-puja mb-3" placeholder="Puja">
                                                    <button type="button" class="btn btn-default btn-pri br-32 w-50 btnpuja"><i class="fas fa-comment-dollar"></i> Pujar</button>
                                                @else
                                                    <a  href="{{ url('/login') }}" type="button" class="btn btn-default btn-pri br-32 w-50"><i class="fas fa-comment-dollar"></i> Pujar</a>
                                                @endif
                                            </div>

                                            <div id="flipdown" class="flipdown" style="margin:auto;"></div>
                                            
                                        @endif
                                        
                            
                                </div>

                            @endif
                        
                        </div>
                                                        
                    </article>
                 
                </div>

            </div>

            @if(count($subastas_relacionadas) > 0)

                <div class="row mt-4">
                    <div class="col">
                        <h3 class="underline pt-10 pb-10 mb-20 text-center fw-bold">También te puede Interesar</h3>
                    </div>
                </div>

                <div class="row mt-4">

                    @foreach($subastas_relacionadas as $subasta_relacionada)

                        <?php $encryptProductRelacionado=Hashids::encode($subasta_relacionada['producto_id']);?> 

                        <div class="col-lg-2 col-md-3 col-6 mb-4 mt-3">

                            <div class="box-producto h-100 d-flex flex-column">

                                <div class="product-image">

                                    <a href="{{ url('producto/'.$subasta_relacionada['url']) }}" class="text-decoration-none">

                                        <!-- Imagen Producto -->
                                        <img class="img-fluid" data-src="{{asset($subasta_relacionada['imagen'])}}" src="{{asset($subasta_relacionada['imagen'])}}" alt="Imagen Producto" title="{{$subasta_relacionada['producto']}}">
                                        <!-- Fin Imagen Producto -->
                                    </a>

                                </div>

                                <div class="box-title mb-2">
                                    <!-- product name -->
                                    <a href="{{ url('producto/'.$subasta_relacionada['url']) }}" class="grid-box-producto-nombre mt-auto" title="{{$subasta_relacionada['producto']}}">
                                        <h3 class="box-producto-title">{{$subasta_relacionada['producto']}}</h3>
                                    </a>
                                    <!-- End product name -->
                                </div>

                                <div class="box-details text-center mt-auto">
                                    <div class="text-center box-price">
                                        @if($subasta_relacionada['precio_min']!= '0.00')
                                            <div class="price">S/. {{$subasta_relacionada['precio_min']}}</div>
                                        @endif
                                    </div>

                                    <div class="text-center" style="padding: 0 2px !important;">
                                        <a href="{{ url('producto/'.$subasta_relacionada['url']) }}" class="btn btn-default btn-pri br-32 w-100" type="button" tabindex="0"><i class="fas fa-eye"></i> Ver</a>
                                    </div>

                                </div>

                                
                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </section>

@endsection

@section('scripts')

<script src="{{ asset('assets/vendor/flipdown-master/src/flipdown.js') }}"></script>

<script>
      @if($subasta['estado'] == 1)
        // Set up FlipDown -- recibe la fecha fin en segundos.
        var flipdown = new FlipDown(<?php echo $dif; ?>, {headings: ["Días", "Horas", "Minutos", "Segundos"],})
        
            // Start the countdown
            .start()
            .ifEnded(() => {
                url=$('meta[name=app-url]').attr("content") + "/producto/fin_subasta";
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "POST",
                        data: {
                            data_subasta: <?php echo '"'.$encryptProductoId.'"'; ?>
                        },
                        success: function(response) {
                            if(response.code == "200")
                            {   
                                $('.cardprecio').html("");
                            }
                        }
                });
                console.log('The countdown has ended!');
            });
        @endif

</script>

@endsection