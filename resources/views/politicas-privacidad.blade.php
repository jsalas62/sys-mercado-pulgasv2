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
                       Políticas de privacidad
                </li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid container-xxl">

        <div class="row">

            <div class="col-7 offset-3">

                <h1 class="text-center mb-4">Política de privacidad</h1>

                <div class="politica-text" style="line-height: 2rem;  text-align: justify; text-justify: inter-word;">

                    <p>1.- Todos los datos ingresados en la web son utilizados únicamente con fines comerciales y/o de reparto. </p>
                    <p>2.- Los datos no se comunicarán a ningún tercero para seguridad y garantía de todos los clientes </p>
                    <p>3.- Como encargados de tratamiento, tenemos contratados a los proveedores de servicios de delivery, 
                    habiéndose comprometido al cumplimiento de las disposiciones normativas, de aplicación en materia de protección de datos, 
                    en el momento de su contratación.</p>

                    <p>4.-En caso de que no nos facilites tus datos o lo hagas de forma errónea o incompleta, no podremos atender 
                    tu solicitud, resultando del todo imposible proporcionarte la información solicitada o llevar a cabo la compra de un producto.</p> 

                    <p>5.-En caso de no haber comunicación con un vendedor autorizado de LaVieja,pe al menos 24 horas después de su compra, 
                    por favor enviar un correo a lavieja1700@gmail.com o a través de una aplicación de mensajería al número 903431983.</p>

                </div>

                
            </div>

        </div>

    </div>


</section>


@endsection