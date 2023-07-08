@extends('master')

@section('content')

<section class="mp-quienes-somos">

    <div class="mp-breadcrumb" aria-label="breadcrumb">
        <nav class="container-xxl">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url('/')}}" title="E-Shop">INICIO</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                       Quienes Somos
                </li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid container-xxl">

        <div class="row">

            <div class="col-7 offset-3">

                <div style="line-height: 2rem;  text-align: justify; text-justify: inter-word;">

                    <p><b>"Mercado de Pulgas Online"</b> es una plataforma en línea que tiene como objetivo revolucionar el tradicional modelo de mercado de pulgas al proporcionar un sitio web seguro y fácil de usar para que los usuarios puedan participar en subastas y vender una amplia variedad de productos.</p>
                    <p>Nuestro enfoque principal es brindar a los vendedores la oportunidad de llegar a una audiencia más amplia, aumentar su visibilidad y mejorar la experiencia del cliente. </p>

                    <p>El sitio web se basa en un emocionante sistema de subastas donde los usuarios, ya sea como vendedores o compradores, pueden participar y realizar pujas. El ganador de la subasta es aquel que realiza la mayor puja dentro del tiempo establecido. Esto agrega emoción y competitividad a las transacciones, permitiendo que los usuarios obtengan productos a precios atractivos y los vendedores obtengan el mejor valor para sus productos.</p>
                    <p>Como empresa, nuestro modelo de negocio se basa en brindar a los usuarios una plataforma confiable para participar en subastas en línea. Cobramos una comisión del 5% sobre el precio final de la subasta ganadora para cubrir los costos operativos y el mantenimiento del sitio web.</p>

                </div>
            
            </div>

        </div>

    </div>


</section>


@endsection