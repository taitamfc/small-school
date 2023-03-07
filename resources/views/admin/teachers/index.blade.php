@extends('admin.layouts.master')
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

            <form action="{{ route('importUser') }}" method="post" enctype="multipart/form-data">
              <a class="btn btn-info" href="{{ route('exportUser') }}">Xuất Excel</a>
              @csrf
              <input type="file" name="importUser">
              <button class="btn btn-success" type="submit">Nhập Excel</button>
            </form>
            @error('importUser')
            <div><code>{{ $message }}</code></div>
            @enderror

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