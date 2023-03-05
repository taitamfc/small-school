
@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý tài khoản</h1><br>
                <a class="btn btn-warning" href="{{ route('users.create') }}">Thêm tài khoản</a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Trang chủ</a></li>
                  <li class="breadcrumb-item active">Quản lý tài khoản</li>
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
                        <a class="btn btn-info" href="{{ route('exportUser') }}">Export</a>
                          @csrf
                        <input type="file" name="importUser">
                      <button class="btn btn-success" type="submit">Import</button>
                    </form>
                    @error('importUser')
                    <div ><code>{{ $message }}</code></div>
                @enderror
                    
                <div class="card card card-primary">
                  <div class="card-header">
               
                    <h3 class="card-title">Danh sách tài khoản</h3>
    
                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        {{ $users->appends(request()->all())->links() }}
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table" style="text-align: center">
                      <thead>
                        <tr>
                          <th style="width: 10%">STT</th>
                          <th>Họ và tên</th>
                          <th>Tên đăng nhập</th>
                          <th>Email</th>
                          <th>Ảnh</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $key => $user)
                        <tr>
                          <td>{{ $key + 1 }}.</td>
                          <td width="20%">{{ $user->full_name }}</td>
                          <td width="20%">{{ $user->user_name }}</td>
                          <td width="20%">{{ $user->email }}</td>
                          <td width="10%"><img width="100%" style="border-radius: 50%" height="30%" src="{{ $user->avatar != '' ? asset($user->avatar) : 'https://taytou.com/wp-content/uploads/2022/08/Avatar-trang-anime-nam-sinh-tay-chong-cam.jpg' }}" alt=""></td>
                            <td width="20%">
                                <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" href="{{ route('users.edit',$user->id) }}">Sửa</a>
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

