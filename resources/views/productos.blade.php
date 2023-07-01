@extends('master')

@section('content')

    <section class="mp-productos">

        <div class="mp-breadcrumb" aria-label="breadcrumb">
            <nav class="container-xxl">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}" title="E-Shop">INICIO</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Productos
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                    {{$productobuscar}}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid container-xxl">

            <div class="row">

                <h1 class="col-lg-9 col-12 mp-categorias-title text-pri">
                    <div class="as-categorias-subtitle">Resultado De Búsqueda Para: </div>'{{$productobuscar}}'</h1>
                    <div class="filter-order col-lg-3 col-12 d-flex justify-content-between align-items-center">

                        @php $var = '' @endphp
                        @if(isset($productobuscar))
                            @php $var = "productBusc=".$productobuscar; @endphp
                        @endif
                        <label>Ordenar:</label>
                        <select name="SortBy" id="SortBy" class="form-control custom-form-input w-45 ms-3" onchange="location = this.value">
                        <option value="{{url('productos?'.$var.'&orderProduct=defecto')}}" {{$order=='defecto' ? 'selected="selected"' : ''}}>Por defecto</option>
                            <option value="{{url('productos?'.$var.'&orderProduct=alfasc')}}" {{$order=='alfasc' ? 'selected="selected"' : ''}}>Alfabéticamente (A-Z)</option>
                            <option value="{{url('productos?'.$var.'&orderProduct=alfdesc')}}" {{$order=='alfdesc' ? 'selected="selected"' : ''}}>Alfabéticamente (Z-A)</option>
                        </select>
                        <input class="collection-header__default-sort" type="hidden" value="manual">

                    </div>
                    
            </div>

            <div class="mt-4" style="overflow:hidden">

                <div class="row pb-15" style="padding-left:2px;">

                    @if(count($productos) > 0)

                        @foreach($productos as $producto)
                            <?php $encryptProduct=Hashids::encode($producto['producto_id']);?>  
                            <div class="col-lg-2 col-md-3 col-6 mb-4">
                                <div class="box-producto h-100 d-flex flex-column">

                                    <div class="product-image">

                                        <a href="{{ url('producto/'.$producto['url']) }}" class="text-decoration-none">

                                            <!-- Imagen Producto -->
                                            <img class="img-fluid" data-src="{{asset($producto['imagen'])}}" src="{{asset($producto['imagen'])}}" alt="Imagen Producto" title="{{$producto['producto']}}">
                                            <!-- Fin Imagen Producto -->
                                        </a>

                                    </div>

                                    <div class="box-title mb-1">
                                        <a href="{{ url('producto/'.$producto['url']) }}" class="grid-box-producto-nombre mt-auto" title="{{$producto['producto']}}">
                                            <h3 class="box-producto-title">{{$producto['producto']}}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                    @else 

                        <div class="col text-center">

                            <h2 class="display-4">Lo Sentimos</h2>
                            <p class="lead mt-4">No encontramos el producto que estas buscando</p>
                            <p class="lead mt-4">
                                <a class="btn btn-primary btn-lg rounded-btn btn-pri" href="{{url('/')}}">Volver al inicio</a>
                            </p>

                        </div>

                    @endif

                </div>

            </div>

            {{ $productos->appends(request()->query())->onEachSide(1)->links('front-partials.pagination-front') }}


        </div>

    </section>

@endsection