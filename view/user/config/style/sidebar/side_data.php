        <!-- untuk home -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
              <a href="#" class="brand-link">
                <img src="../../template/dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Rental Mobil</span>
              </a>

              <!-- Sidebar -->
            <div class="sidebar">
              <!-- Sidebar user panel (optional) -->
               <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../template/dist/img/user.png" class="img-circle elevation-2" alt="User Image" style="filter: invert(1);">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['nama']; ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->

                  <li class="nav-item">
                      <a href="index.php" class="nav-link">
                          <i class="nav-icon fas fa-home"></i>
                          <p>
                              Home
                          </p>
                      </a>
                  </li>
                  
                  <li class="nav-item">
                      <a href="?mobil=data_mobil" class="nav-link active">
                          <i class="nav-icon fas fa-car"></i>
                          <p>
                              Data Mobil
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="?pinjam=data_peminjaman" class="nav-link">
                          <i class="nav-icon fas fa-hand-holding-water"></i>
                          <p>
                              Peminjaman Mobil
                          </p>
                      </a>
                  </li>
                  
                </ul>
              </nav>
            <!-- /.sidebar-menu -->
            </div>
              <!-- /.sidebar -->
        </aside>
