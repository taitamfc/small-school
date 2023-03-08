
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
                <h1>Quản lý học sinh</h1><br>

                <a class="btn btn-warning" href="{{ route('student.create') }}">Thêm học sinh </a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('login') }}">Trang chủ</a></li>
                  <li class="breadcrumb-item active">Quản lý học sinh</li>
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

                      <form action="{{ route('student.import') }}" method="post" enctype="multipart/form-data">
                        <a class="btn btn-info" href="{{ route('exportUser') }}">Xuất Excel</a>
                          @csrf
                        <input type="file" name="import_student">
                      <button class="btn btn-success" type="submit">Nhập Excel</button>
                      <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Tìm kiếm chi tiết
                      </button>
                    </form>
                    @error('import_student')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror


                <div class="collapse  text-center" id="collapseExample">
             <div class="col-12">
                  <section class="content">
                    <div class="container-fluid">
                        <form action="{{ route('student.index') }}" method="GET" id="form-search">
                          @csrf
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Họ và tên</label>
                                                <input type="text" name="full_name" class="form-control form-control-lg" placeholder="Tìm theo họ và tên" value="{{ request()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                          <div class="form-group">
                                              <label>Số điện thoại</label>
                                              <input type="text" name="phone" class="form-control form-control-lg" placeholder="Tìm theo số điện thoại" value="{{ request()->phone }}">
                                          </div>
                                      </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Tên phòng</label>
                                                <input type="text" name="room_name" class="form-control form-control-lg" placeholder="Tìm theo tên phòng" value="{{ request()->room_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="text" name="email" class="form-control form-control-lg" placeholder="Tìm theo Email" value="{{ request()->email }}">
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

                    <h3 class="card-title">Danh sách học sinh</h3>

                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        {{ $students->appends(request()->all())->links() }}
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table" style="text-align: center">
                      <thead>
                        <tr>
                          <th style="width: 10%">STT</th>
                          <th>Họ và tên</th>
                          <th>Số điện thoại</th>
                          <th>Tên phòng</th>
                          <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Sinh nhật</th>
                            <th>Ảnh </th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach($students as $key => $student)
                        <tr>
                          <td>{{ $key + 1 }}.</td>
                          <td width="20%">{{ $student->name }}</td>
                          <td width="20%">{{ $student->phone }}</td>
                            <td width="20%">{{ $student->room_name }}</td>
                            <td width="20%">{{ $student->email }}</td>
                            <td width="20%">{{ $student->status }}</td>
                            <td width="20%">{{ $student->birthday }}</td>
                            <td width="10%"><img width="100%" style="border-radius: 50%" height="30%" src="{{ $student->image }}" alt=""></td>

                            <td width="20%">
                                <form action="{{route('student.destroy',$student->id)}}" method="post">
                                    @method('DELETE')
                                @csrf

                                <a class="btn btn-warning" href="{{route('student.edit', $student->id)}}">Sửa</a>
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                            </form></td>
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


