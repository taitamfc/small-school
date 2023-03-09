@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('users.login') }}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Quản lý giáo viên</li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Quản lý giáo viên</h1><br>
          
          <a class="btn btn-warning" href="{{ route('teachers.create') }}">Thêm giáo viên</a>
          <a class="btn btn-info" href="{{ route('teachers.export') }}">Xuất Excel</a>
          <a class="btn btn-primary" href="{{ route('teachers.viewImport') }}">Nhập Excel</a>

          <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Tìm kiếm chi tiết
          </button>
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
                <div class="collapse" id="collapseExample">
                  <div class="row">
                    <div class="col-12"> 

                      <form action="{{ route('teachers.index') }}" method="GET" id="form-search">
                        @csrf
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Tên</label>
                                                <input type="text" name="name" class="form-control" placeholder="Tìm theo tên..." value="{{ request()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="Tìm theo email..." value="{{ request()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Level</label>
                                                <input type="text" name="level" class="form-control" placeholder="Tìm theo level..." value="{{ request()->level }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label style="display: block">Hành động</label>
                                                <input type="submit" class="btn btn-default" value="Xác nhận">
                                            </div>  
                                        </div>
                                    
                                  </div>
                              </div>
                          </div>
                      </form>

                  </div>
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
                      <th>Ảnh</th>
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
                      <td width="10%"><img width="100%" style="border-radius: 50%" height="90px" src="{{ $teacher->image != '' ? asset($teacher->image) : 'https://taytou.com/wp-content/uploads/2022/08/Avatar-trang-anime-nam-sinh-tay-chong-cam.jpg' }}" alt=""></td>
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