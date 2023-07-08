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
                        Página no encontrada
                    </li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid container-xxl">

            <div class="row">

                <div class="col">

                    <h2 class="display-4 text-center">Lo Sentimos</h2>
                    <p class="lead text-center mt-4">No encontramos el contenido que estas buscando</p>
                    <p class="lead text-center mt-4">
                        <a class="btn btn-primary btn-lg bradius btn-pri" href="{{url('/')}}">Volver al inicio</a>
                    </p>

                </div>

            </div>

        </div>

    </section>

@endsection