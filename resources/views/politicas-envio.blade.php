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
                       Políticas de Envío
                </li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid container-xxl">

        <div class="row">

            <div class="col-7 offset-3">

                <h1 class="text-center mb-4">Política de envío</h1>

                <div class="politica-text" style="line-height: 2rem;  text-align: justify; text-justify: inter-word;">

                <p>1.- Mercado de Pulgas NO CUENTA CON DELIVERY PROPIO, nuestro servicio de delivery se encuentra tercerizado. 
                El costo de cualquier cambio de producto (sea por error de cliente, falta de conformidad, etc) 
                será asumido por el cliente.</p>
                <p>2.-Nuestro delivery tiene autonomía en cuanto al orden de entrega, la hora de llegada, etc. Se comunicará al cliente 
                un rango horario para poder esperar el delivery dependiendo de la hora del día en que se haya hecho el pedido. 
                De no cumplirse este horario, se debe comunicar a los contactos brindados anteriormente o a las redes sociales 
                de LaVieja.pe. </p>
                <p>3.- El delivery llegará al punto de entrega donde puede esperarle máximo 10 minutos para su recepción y 15 minutos 
                para que pueda revisar correctamente lo recibido dando al delivery la conformidad y así este pueda retirarse. </p>
                <p>4.-En caso de un envío de provincia, se trabaja directamente con la agencia Olva Courier para cualquier envío 
                provincial, por lo que los precios de entrega en provincia están directamente ligados con esta agencia de reparto. Si el cliente desea otra agencia debe seleccionar la opción de recojo en tienda e inmediatamente comunicarse al 903431983 para que se pueda hacer el pago del envío a la agencia elegida y el costo de envío a provincia será asumida por el cliente en contraentrega. 
                </p>
                </div>

                
            </div>

        </div>

    </div>


</section>


@endsection