<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('teachers.dashboard') }}" class="brand-link">
        <img src="{{asset('asset/plugins/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Giáo Viên</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('teachers.dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.events.calendar') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p> Thời khóa biểu </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.events.histories') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p> Lịch sử giảng dạy </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.events.salary') }}" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p> Thống kê tiền lương </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.tasks.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Quản lý yêu cầu </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teachers.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p> Cập nhật tài khoản </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>