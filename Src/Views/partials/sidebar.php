<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/gestion-clinicas/public/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#usuarios-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="usuarios-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="/gestion/public/lista_usuarios">
            <i class="bi bi-circle"></i><span>Listar Usuarios</span>
          </a>
        </li>
        <li>
          <a href="/gestion/public/registro">
            <i class="bi bi-circle"></i><span>Crear Usuario</span>
          </a>
        </li>
        <li>
          <a href="/gestion/public/usuarios_asignar">
            <i class="bi bi-circle"></i><span>Asignar Roles</span>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#servicios-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-collection"></i><span>Servicios</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="servicios-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="/gestion/public/servicios">
            <i class="bi bi-circle"></i><span>Listar Servicios</span>
          </a>
        </li>
        <li>
          <a href="/gestion/public/servicios_crear">
            <i class="bi bi-circle"></i><span>Crear Servicio</span>
          </a>
        </li>
        <li>
          <a href="/gestion/public/usuarios_asignar">
            <i class="bi bi-circle"></i><span>Asignar Servicios</span>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#clinicas-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-building"></i><span>Departamentos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="clinicas-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="/gestion/public/laboratorio">
            <i class="bi bi-circle"></i><span>Crear Laboratorio</span>
          </a>
        </li>
        <li>
          <a href="/gestion/public/crear_laboratorio">
            <i class="bi bi-circle"></i><span>Listar Departamentos</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/gestion-clinicas/public/acciones_registro">
        <i class="bi bi-list-check"></i>
        <span>Registro de Acciones</span>
      </a>
    </li>
  </ul>
</aside>