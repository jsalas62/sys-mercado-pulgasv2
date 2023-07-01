<div class="container-fluid container-xxl">

    <div class="row mt-4">

        <div class="col-12">

            <ul class="main-bar d-flex align-items-center justify-content-start gap-4">
                <li class="main-bar-item"><a href="{{url('/user/pujas')}}">Mis Pujas</a></li>
                <li class="main-bar-item"><a href="{{url('/user/subastas')}}">Mis Subastas</a></li>
                @can('admin.categorias.index')
                <li class="main-bar-item"><a href="{{url('/user/categorias')}}">Mis Categorías</a></li>
                @endcan
                @can('admin.productos.index')
                <li class="main-bar-item"><a href="{{url('/user/productos')}}">Mis Productos</a></li>
                @endcan
                <li class="main-bar-item"><a href="{{url('/user/misdatos')}}">Mis Datos</a></li>
                <li class="main-bar-item"><a href="{{url('/user/contrasenia')}}">Contraseña</a></li>
                @can('admin.usuarios.index')
                <li class="main-bar-item"><a href="{{url('/user/usuarios')}}">Usuarios</a></li>
                @endcan
                @can('admin.roles.index')
                <li class="main-bar-item"><a href="{{url('/user/roles')}}">Roles</a></li>
                @endcan
                <li class="main-bar-item"><a href="{{ url('logout') }}">Cerrar Sesión</a></li>
            </ul>
      

        </div> 


    </div>

</div>