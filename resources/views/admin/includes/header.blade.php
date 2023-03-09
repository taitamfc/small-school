 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
  
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" id="search" type="search" name="key" value="{{ request()->key }}" placeholder="Tìm kiếm" aria-label="Search">
             
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          @if(isset(Auth::user()->full_name))
          <span class="dropdown-item dropdown-header">Tài khoản <i class="fas fa-user"></i><br><b>{{ Auth::user()->full_name}}</b></span>
          @elseif (isset(Auth()->guard('teachers')->user()->name))
          <span class="dropdown-item dropdown-header">Tài khoản <i class="fas fa-user"></i><br><b>{{ Auth()->guard('teachers')->user()->name}}</b></span>
          @elseif (isset(Auth()->guard('students')->user()->name))
          <span class="dropdown-item dropdown-header">Tài khoản <i class="fas fa-user"></i><br><b>{{ Auth()->guard('students')->user()->name}}</b></span>
          @endif
          <div class="dropdown-divider"></div>
          @if(isset(Auth::user()->full_name))
          <a href="{{ route('users.logout') }}" class="dropdown-item text-center">Đăng xuất
            <i class="fas fa-sign-out-alt"></i>
          </a>
            @elseif (isset(Auth()->guard('teachers')->user()->name))
          <a href="{{ route('teachers.logout') }}" class="dropdown-item text-center">Đăng xuất
            <i class="fas fa-sign-out-alt"></i>
          </a>
            @elseif (isset(Auth()->guard('students')->user()->name))
          <a href="{{ route('student.logout') }}" class="dropdown-item text-center">Đăng xuất
            <i class="fas fa-sign-out-alt"></i>
          </a>
          @endif
        </div>
      </li>
    </ul>
  </nav>