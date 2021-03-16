 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/panel/home.php" class="brand-link">
      <img src="/panel/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Chelech Net</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php $obj = new metodos();
            $sql = "select nombreUsuario from usuarios where idusuario=$idUsuario";
            $resultName = $obj->mostrarDatos($sql);
            foreach($resultName as $name){
              echo "Bienvenido ".ucwords($name['nombreUsuario']);
            }
          ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if ($rolUsuario==='administrador'): ?>
            <!--bodegas-->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-archive"></i>
                  <p>
                    BODEGAS
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addCustomer.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar compradores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addSeller.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar trabajadores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addSupplier.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar abastecimientos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/tables/ingresos.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Ingresos</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/fin bodega-->
              <!--finanzas-->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-money-bill"></i>
                  <p>
                    FINANZAS
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/panel/pages/forms/checkPendingDocs.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Realizar Consultas</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/fin finanzas-->
          <?php endif ?>
          <!--televenta-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                TELEVENTA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/panel/pages/forms/startProcess.php" class="nav-link">
                  <i class="fas fa-play-circle nav-icon"></i>
                  <p>Iniciar proceso</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/panel/pages/tables/televenta/listadoLinks.php" class="nav-link">
                  <i class="fas fa-clipboard-list nav-icon"></i>
                  <p>Listado Transacciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/panel/pages/forms/boton.php" class="nav-link">
                  <i class="fas fa-share-square nav-icon"></i>
                  <p>Generar botón de pago</p>
                </a>
              </li>
            </ul>
          </li>
          <!--/fin televenta-->

          <!-- catalogo -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-window-restore"></i>
              <p>
                CATALOGO VIRTUAL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/panel/pages/forms/selectorBodega.php" class="nav-link">
                  <i class="fas fa-play-circle nav-icon"></i>
                  <p>Revisar Bodegas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/panel/pages/tables/catalogoweb.php" class="nav-link">
                  <i class="fas fa-file-invoice"></i>
                  <p>Previsualizacion catalogo</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- /fin catalogo -->
          <!--acciones de sesion-->
          <li class="nav-header">DOCUMENTACION Y MANUALES</li>
          <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-archive"></i>
                  <p>
                    Sección Televenta
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 <li class="nav-item">
                    <a href="/documents/manual/botonPago.pdf" class="nav-link" target="_blank">
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p class="text">BOTON DE PAGO</p>
                    </a>
                  </li>
                </ul>
              </li>
          <li class="nav-header">ACCIONES DE SESIÓN</li>
          <li class="nav-item">
            <a href="/panel/pages/forms/editarUsuario.php" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Editar Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/panel/php/goes/logout.php" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Cerrar sesión</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>