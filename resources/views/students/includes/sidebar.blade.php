<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('students.dashboard') }}" class="brand-link">
      <img src="{{asset('asset/plugins/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Học Viên</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->


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
            <a href="{{ route('students.dashboard') }}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Trang chủ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('students.events.calendar') }}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Thời khóa biểu </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('students.events.calendar') }}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Yêu cầu </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('students.events.calendar') }}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Lịch sử học tập </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('students.profile') }}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Cập nhật tài khoản </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>