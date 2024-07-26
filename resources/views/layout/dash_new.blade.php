<body class="hold-transition sidebar-mini layout-fixed">


  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img src="{{tracesciimg('preloader.gif')}}" alt="Loading..." height="100" width="100">
    <p style="font-weight: bolder;">Loading...</p>

  </div>

  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="font-size:17px;">
    <!-- Brand Logo -->
    <img src="{{tracesciimg('tracescilogo.png')}}" alt="tracesci" class="brand-image" style="margin-top:14px;margin-left:16px;margin-bottom:14px;">
    <span class="brand-text font-weight-light" style="font-size: x-large; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; "></span>
    <!-- Sidebar -->
    <div class="sidebar">
     <hr class="my-4 bg-light">

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? ' active select_colour' : ''}}">
              <i class="fas fa-tachometer-alt icon"></i>
              <p>
                DASHBOARD
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('products.index')}}" class="nav-link {{ Route::is('products.*') ? ' active select_colour' : '' }}">
              <i class="nav-icon fas fa-shopping-bag icon"></i>
              <p>
                PRODUCTS
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('batches.index') }}" class="nav-link {{ Route::is('batches.*') ? ' active select_colour' : '' }}" >
              <i class="nav-icon fas fa-boxes icon"></i>
              <p>
                BATCHES
              </p>
            </a>

          </li>
          <li class="nav-item has-treeview {{ Route::is('production-plants.*')  || Route::is('production-lines.*') ? ' menu-open' : '' }}" id="products-menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-industry icon" aria-hidden="true"></i>
              <p>
                PRODUCTION
                <i class="right fas fa-angle-right icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ">
              <li class="nav-item">
                <a href="{{route('production-plants.index')}}" class="nav-link {{ Route::is('production-plants.*') ? ' active select_colour' : '' }}">
                  <i class="fa fa-atom nav-icon icon"></i>
                  <p>Production Plants</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('production-lines.index')}}" class="nav-link {{ Route::is('production-lines.*') ? ' active select_colour' : '' }}">
                  <i class="fa fa-book nav-icon icon" aria-hidden="true"></i>
                  <p>Production Lines</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item ">
            <a href="{{route('jobs.index')}}" class="nav-link {{ Route::is('jobs.*') ? ' active select_colour' : '' }}">
              <i class="nav-icon fas fa-briefcase icon"></i>
              <p>
                JOBS
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{route('print.index')}}" class="nav-link {{ Route::is('print.*') ? ' active select_colour' : '' }}">
              <i class="nav-icon fas fa-print icon"></i>
              <p>
                PRINT MODULE
              </p>
            </a>
          </li>
          <li class="nav-item {{ Route::is('qrcodes.*')  || Route::is('bulkuploads.*') || Route::is('scanhistories.*') || Route::is('reportlog.*') ? ' menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-qrcode icon"></i>
              <p>
                QR-CODES
                <i class="fas fa-angle-right right icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('qrcodes.index')}}" class="nav-link {{ Route::is('qrcodes.*') ? ' active select_colour' : '' }}">
                  <i class="nav-icon fas fa-qrcode icon"></i>
                  <p>QR Code</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('bulkuploads.index')}}" class="nav-link  {{ Route::is('bulkuploads.*') ? 'active select_colour' : '' }}">
                  <i class="fas fa-file-upload nav-icon icon"></i>
                  <p>Bulk Uploads</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('scanhistories.index')}}" class="nav-link  {{ Route::is('scanhistories.*') ? ' active select_colour' : '' }}">
                  <i class=" nav-icon fas fa-barcode icon" aria-hidden="true"></i>
                  <p>
                    Scan Histories
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reportlog.show')}}" class="nav-link {{ Route::is('reportlog.show') ? 'active select_colour' : '' }}">
                  <i class="nav-icon fas fa-book icon"></i>
                  <p>Consumer Feedback</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Route::is('permissions.*') || Route::is('roles.*') || Route::is('users.*') || Route::is('userlog.*') ? ' menu-open' : '' }}" id="products-menu">
            <a href="#" class="nav-link">
              <i class=" nav-icon fas fa-newspaper icon"></i>
              <p>
                Users
                <i class="fas fa-angle-right right icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.index')}}" class="nav-link  {{ Route::is('users.*') ? 'active select_colour' : '' }}">
                  <i class="fas fa-users nav-icon icon"></i>
                  <p>
                    User's Data
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('roles.index')}}" class="nav-link  {{ Route::is('roles.*') ? ' active select_colour' : '' }}">
                  <i class="fas fa-user-check nav-icon icon"></i>
                  <p>
                    Roles
                  </p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('permissions.index')}}" class="nav-link {{ Route::is('permissions.*') ? ' active select_colour' : '' }}">
                  <i class="nav-icon fas fa-lock icon" aria-hidden="true"></i>
                  <p>
                    Permissions
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('userlog.show')}}" class="nav-link {{ Route::is('userlog.show') ? 'active select_colour' : '' }}">
                  <i class="nav-icon fas fa-newspaper icon"></i>
                  <p>USER LOGS</p>
                </a>
              </li>
            </ul>
          </li>
          <div class="logo" style="text-align:center">
            <a href="" class="simple-text logo-normal">
              <img class="img-size" src="{{tracesciimg('tracescilogo.png')}}" style="max-width:70%;">
            </a>
          </div>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->