<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="profile-image">
                <img src="{{ asset('admin_assets/images/boy2.png') }}" alt="profile"/>
              </div>
              <div class="profile-name">
              Bienvenido(a) 
                <p class="name">
                    Super Admin
                </p>
                <!-- <p class="designation">
                  Super Admin
                </p> -->
              </div>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/') }}">
              <i class="fas fa-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>   

          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/categorias') }}">
            <i class="fas fa-cubes menu-icon"></i>
              <span class="menu-title">Categorías</span>
            </a>
          </li>

        
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/productos') }}">
              <i class="fas fa-dolly-flatbed menu-icon"></i>
              <span class="menu-title">Productos</span>
            </a>
          </li>    

          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/roles') }}">
            <i class="fas fa-bezier-curve menu-icon"></i>
              <span class="menu-title">Roles</span>
            </a>
          </li> 

          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/usuarios') }}">
              <i class="fas fa-users menu-icon"></i>
              <span class="menu-title">Usuarios</span>
            </a>
          </li> 

        </ul>
      </nav>