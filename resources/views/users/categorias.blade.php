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

    <div class="row mt-5 px-4">
       
        <div class="col-xl-7 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtBuscarCategoria" style="font-size:14px;">Categoría: </label>
                <input type="text" class="form-control form-custom-input" id="txtBuscarCategoria" placeholder="Código o nombre de la Categoría...">
            </div>
        </div>

        <div class="col-xl-5 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoCategoriaBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoCategoriaBuscar" id="estadoCategoriaBuscar" class="form-control form-custom-input">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>
        
    </div>

    <div class="row px-4">
        <div class="col-xl-12 col-md-12 col-sm-12 d-flex justify-content-end mt-4">

            <div class="form-group mr-20-sm">
                <button type="button" class="btn btn-sm btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalCategoria"><img src="{{ url('admin_assets/images/add2.png') }}" alt="agregar" width="25px"> Agregar Categoría</button>
            </div>

        </div>
    </div>

    <div class="row mt-3">

        <div class="col-12 grid-margin">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                    <i class="fas fa-cubes"></i>
                        Listado de Categorías
                    </h4>
                    <section class="categorias">
                        @if(isset($categorias) && count($categorias) > 0)
                            
                            @include('users.data.categorias-data')
                        
                        @else 
                        
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Categoría</th>
                                        <th>Descripción</th>
                                        <th>URL</th>                                            
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="6">No se encontraron registros</td>
                                        </tr>
                                
                                    </tbody>
                                </table>
                            </div>
                            
                        @endif
                    </section>
                </div>  

            </div>

        </div>
    </div>

    <div class="row justify-content-center mt-5 mb-4">
        <div class="col-sm-5 align-self-center text-center">
            <div class="card">
                <div class="card-body">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Leyenda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/edit.png') }}" alt="Editar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Editar Categoría</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/delete3.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Eliminar Categoría</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/on.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Activar Categoría</td>
                            </tr>
                            <tr>
                                <td><img src="{{ url('admin_assets/images/off.png') }}" alt="Eliminar" style="width:22px;height:22px;"></td>
                                <td style="font-size:14px">Desactivar Categoría</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Agregar -->
<div class="modal fade" id="ModalCategoria" tabindex="-1" aria-labelledby="ModalCategorialabel" aria-hidden="true" ata-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document" style="margin-top:20px;">
        <div class="modal-content">

            <form role="form" method="post" return="false" id="formCategoria" name="formCategoria">

                <div class="modal-header" style="background-color:#ac56fa">
                    <h5 class="modal-title font-weight-bold text-primary" id="tituloModalCategoria" style="color:white !important">AGREGAR CATEGORÍA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclicK="limpiarModalCategoria()"></button>
                </div>

                <div class="modal-body">
                
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card mb-4">

                                <div class="card-body">

                                    <div id="error-div"></div>
                            
                                    <div class="form-group mt-2">
                                        <label for="txtCategoria"><b>Categoría:</b></label>
                                        <input type="hidden" name="hddcategoria_id" id="hddcategoria_id" value="">
                                        <input type="hidden" name="slug_actual" id="slug_actual" value="">
                                        <input type="text" class="form-control ml-2 form-custom-input br-0 mt-2" id="txtCategoria"  name="txtCategoria" aria-describedby="emailHelp"
                                            placeholder="Ingrese la categoría">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="txtDescripcionCategoria"><b>Descripción:</b></label>
                                        <textarea class="form-control ml-2 form-custom-input br-0 mt-2" name="txtDescripcionCategoria" id="txtDescripcionCategoria" cols="20" rows="3" placeholder="Ingrese la Descripción.."></textarea>
                                    </div>
                                    
                                    <div class="form-group mt-2">
                                        <label for="chkEstadoCategoria"><b>Estado:</b></label>
                                        <div class="custom-control custom-checkbox ml-2">
                                            <input type="checkbox" class="custom-control-input" name="chkEstadoCategoria" id="chkEstadoCategoria" checked>  
                                            <label class="custom-control-label" for="chkEstadoCategoria">Activo</label>
                                        </div>
                                    </div>
                            
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-dark" id="btnGuardarCategoria"> <img src="{{ url('admin_assets/images/save.png') }}" width="20px" height="20px"> GUARDAR</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarCategoria" data-bs-dismiss="modal" onclick="limpiarModalCategoria()"> <img src="{{ url('admin_assets/images/cancel.png') }}" width="20px" height="20px"> CERRAR</button>
                
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/categorias.js') }}"></script>

@endsection