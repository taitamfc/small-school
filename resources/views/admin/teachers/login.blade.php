<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('asset/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/plugins/css/adminlte.min.css')}}">
</head>
<style>
  .error{
      color:red;
  }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Admin</b>School</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng nhập hệ thống để tiếp tục</p>
      <form action="{{ route('teachers.checkLogin') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" value="{{ old('email')}}" placeholder="Email">
       
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('email')
          <b class="error">{{ $message }}</b>
        @enderror
      
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" value="{{ old('password')}}" placeholder="Mật khẩu">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
          <b class="error">{{ $message }}</b>
         @enderror
        <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Nhớ tài khoản
              </label>
            </div>
          </div>
          <div class="col-5">
            <button type="submit" class="btn btn-warning btn-block">Đăng nhập</button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="{{ route('users.login') }}" class="btn btn-block btn-danger">
          Đăng nhập với tư cách Quản trị viên
        </a>
        <a href="{{ route('students.login') }}" class="btn btn-block btn-primary">
         Đăng nhập với tư cách Học sinh
        </a>
      </div>
      <p class="mb-1">
        <a href="forgot-password.html">Quên mật khẩu</a>
      </p>
    </div>
  </div>
</div>
<script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('asset/plugins/js/adminlte.min.js')}}"></script>
</body>
</html>