<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('asset/plugins/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>
                @if (Auth::user()->hasPermission('User_viewAny') || Auth::user()->hasPermission('User_create'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Quản lý nhân viên
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::user()->hasPermission('User_viewAny'))
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <p>Danh sách nhân viên</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasPermission('User_create'))
                                <li class="nav-item">
                                    <a href="{{ route('users.create') }}" class="nav-link">
                                        <p>Thêm nhân viên</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Group_viewAny') || Auth::user()->hasPermission('Group_create'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Quản lý chức vụ
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::user()->hasPermission('Group_viewAny'))
                                <li class="nav-item">
                                    <a href="{{ route('groups.index') }}" class="nav-link">
                                        <p>Danh sách chức vụ</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasPermission('Group_create'))
                                <li class="nav-item">
                                    <a href="{{ route('groups.create') }}" class="nav-link">
                                        <p>Thêm chức vụ</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Teacher_viewAny') || Auth::user()->hasPermission('Teacher_create'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Quản lý giáo viên
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if (Auth::user()->hasPermission('Teacher_viewAny'))
                                <li class="nav-item">
                                    <a href="{{ route('teachers.index') }}" class="nav-link">
                                        <p>Danh sách giáo viên</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('events.salary') }}" class="nav-link">
                                    <p>Lương giáo viên</p>
                                </a>
                            </li>
                            @if (Auth::user()->hasPermission('Teacher_create'))
                                <li class="nav-item">
                                    <a href="{{ route('teachers.create') }}" class="nav-link">
                                        <p>Thêm giáo viên</p>
                                    </a>
                                </li>
                            @endif
                            
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Student_viewAny') || Auth::user()->hasPermission('Student_create'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Quản lý học viên
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            
                            @if (Auth::user()->hasPermission('Student_viewAny'))
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}" class="nav-link">
                                    <p>Danh sách học viên</p>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasPermission('Student_create'))
                            <li class="nav-item">
                                <a href="{{ route('students.create') }}" class="nav-link">
                                    <p>Thêm học viên</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Event_viewAny') || Auth::user()->hasPermission('Event_create'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Quản lý sự kiện
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                           
                            @if (Auth::user()->hasPermission('Event_viewAny'))
                            <li class="nav-item">
                                <a href="{{ route('events.index') }}" class="nav-link">
                                    <p>Danh sách sự kiện</p>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasPermission('Event_viewAny'))
                            <li class="nav-item">
                                <a href="{{ route('systemCalendar') }}" class="nav-link">
                                    <p>Lịch</p>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->hasPermission('Event_create'))
                            <li class="nav-item">
                                <a href="{{ route('events.create') }}" class="nav-link">
                                    <p>Thêm sự kiện</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Task_viewAny') || Auth::user()->hasPermission('Task_create'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Quản lý yêu cầu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->hasPermission('Task_viewAny'))
                        <li class="nav-item">
                            <a href="{{ route('tasks.index') }}" class="nav-link">
                                <p>Danh sách yêu cầu</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('Task_create'))
                        <li class="nav-item">
                            <a href="{{ route('tasks.create') }}" class="nav-link">
                                <p>Thêm yêu cầu</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasPermission('Task_viewAny') || Auth::user()->hasPermission('Task_create'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Quản lý lớp học
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->hasPermission('Task_viewAny'))
                        <li class="nav-item">
                            <a href="{{ route('rooms.index') }}" class="nav-link">
                                <p>Danh sách lớp học</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('Task_create'))
                        <li class="nav-item">
                            <a href="{{ route('rooms.create') }}" class="nav-link">
                                <p>Thêm lớp học</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
