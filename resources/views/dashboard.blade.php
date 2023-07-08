@extends('temlate')

@section('content')

<div class="container">

    <div class="row mt-3">

        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{url('/')}}">
                <img class="img-fluid" src="{{asset('assets/images/logo22.jpg')}}" width="358">
            </a>
            <a href="{{url('/')}}" class="login-back-link blue">
                <i class="fas fa-arrow-left"></i>
                <span>Regresar a la tienda</span>
            </a>
        </div>

    </div>

      
</div>

@include('front-partials.navbar-account')

<div class="container-fluid container-xxl">

    <div class="slider-main mt-5">

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

</div>

@endsection