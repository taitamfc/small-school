<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Material Design for Bootstrap</title>
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <link rel="stylesheet" href="{{ asset('asset/plugins/css/bootstrap-login-form.min.css') }}" />
</head>
<style>
    .error{
        color:red;
    }
</style>
<body>
  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
  
              <h3 class="mb-5">Đăng nhập giáo viên</h3>
                <form action="{{ route('teachers.checkLogin') }}" method="post">
                    @csrf
              <div class="form-outline mb-4">
                <input type="email" name="email" id="typeEmailX-2" value="{{ old('email')}}" class="form-control form-control-lg" />
                <label class="form-label" for="typeEmailX-2">Email</label>
                @error('email')
                    <b class="error">{{ $message }}</b>
                @enderror
              </div>
  
              <div class="form-outline mb-4">
                <input type="password" name="password" id="typePasswordX-2" value="{{ old('password')}}" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX-2">Password</label>
                @error('password')
                <b class="error">{{ $message }}</b>
                @enderror
              </div>
  
              <div class="form-check d-flex justify-content-start mb-4">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="form1Example3"
                />
                <label class="form-check-label" for="form1Example3"> Ghi nhớ tài khoản</label>
              </div>
  
              <button class="btn btn-primary btn-lg btn-block" type="submit">Đăng nhập</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="{{ asset('asset/plugins/js/mdb.min.js') }}"></script>

</body>

</html>