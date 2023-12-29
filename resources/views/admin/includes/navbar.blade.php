  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('admin.dashboard') }}" class="nav-link">الرئيسية</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('admin.logout') }}" class="nav-link">تسجيل الخروج</a>
          </li>
      </ul>



      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
          </li>


      </ul>
  </nav>
  <!-- /.navbar -->
