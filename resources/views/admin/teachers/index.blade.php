@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<style>
  .form-control-lg{
    height: calc(2.3000rem + 2px); !important
  }
</style>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quản lý giáo viên</h1><br>
            <a class="btn btn-warning" href="{{ route('teachers.create') }}">Thêm giáo viên</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('login') }}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Quản lý giáo viên</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
              {{ session('error') }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('importTeacher') }}" method="post" enctype="multipart/form-data">
              <a class="btn btn-info" href="{{ route('exportTeacher') }}">Xuất Excel</a>
              @csrf
              <input type="file" name="importTeacher">
              <button class="btn btn-success" type="submit">Nhập Excel</button>
             <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Tìm kiếm chi tiết
                      </button>
                    </form>
                    @error('importTeacher')
                    <div ><code>{{ $message }}</code></div>
                @enderror
        
                <div class="collapse  text-center" id="collapseExample">
             <div class="col-12"> 
                  <section class="content">
                    <div class="container-fluid">
                        <form action="{{ route('teachers.index') }}" method="GET" id="form-search">
                          @csrf
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Tên:</label>
                                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Tìm theo tên..." value="{{ request()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                          <div class="form-group">
                                              <label>Email:</label>
                                              <input type="text" name="email" class="form-control form-control-lg" placeholder="Tìm theo email..." value="{{ request()->email }}">
                                          </div>
                                      </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="text" name="level" class="form-control form-control-lg" placeholder="Tìm theo level..." value="{{ request()->level }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default">
                                                    Xác nhận
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                </div>
              </div>

            <div class="card card card-primary">
              <div class="card-header">

                <h3 class="card-title">Danh sách giáo viên</h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    {{ $teachers->appends(request()->all())->links() }}
                  </ul>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table" style="text-align: center">
                  <thead>
                    <tr>
                      <th style="width: 10%">STT</th>
                      <th>Họ và tên</th>
                      <th>Email</th>
                      <th>Cấp độ</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($teachers as $key => $teacher)
                    <tr>
                      <td>{{ $key +1 }}.</td>
                      <td>{{ $teacher->name }}</td>
                      <td>{{ $teacher->email }}</td>
                      <td>{{ $teacher->level }}</td>
                      <td>{{ $teacher->status }}</td>
                      <td>
                        <form action="{{ route('teachers.destroy',$teacher->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a class="btn btn-info" href="{{ route('teachers.edit',$teacher->id) }}">Sửa</a>
                          <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection
@section('footer_scripts')
<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    $('.select2').select2()
  });
</script>
@endsection