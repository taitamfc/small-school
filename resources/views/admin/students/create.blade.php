
@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý học sinh</h1><br>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('users.login') }}">Trang chủ</a></li>
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
                <div class="card card-primary">
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
                  <div class="card-header">

                    <h3 class="card-title">Thêm học sinh</h3><br>
                  </div>
                  <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-4">
                              <label>Họ và tên</label>
                              <input type="text" class="form-control" name="name"  placeholder="Nhập họ và tên">
                              @error('name')
                              <div ><code>{{ $message }}</code></div>
                            @enderror
                            </div>

                            <div class="form-group col-md-4">
                              <label>Số điện thoại</label>
                              <input type="text" class="form-control" name="phone"  placeholder="Nhập số điện thoại">
                              @error('phone')
                              <div ><code>{{ $message }}</code></div>
                          @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Tên phòng</label>
                                <input type="text" class="form-control" name="room_name"  placeholder="Nhập tên phòng">
                                @error('room_name')
                                <div ><code>{{ $message }}</code></div>
                                @enderror

                        </div>
                            <div class="form-group col-md-4">
                                <label>E-mail</label>
                                <input type="text" class="form-control" name="email"  placeholder="Nhập E-mail">
                                @error('email')
                                <div ><code>{{ $message }}</code></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mật khẩu</label>
                                <input type="password" class="form-control" name="password"  placeholder="Nhập mật khẩu">
                                @error('password')
                                <div ><code>{{ $message }}</code></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ngày sinh</label>
                                <input type="date" class="form-control" name="birthday"  placeholder="Nhập ngày sinh nhật">
                                @error('birthday')
                                <div ><code>{{ $message }}</code></div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputFile">Ảnh đại diện</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="exampleInputFile">Chọn ảnh</label>
                                        <input type='file' class="custom-file-input" id="imgInp" name="image" />
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tải ảnh lên</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Trạng thái</label>
                                <input type="text" class="form-control" name="status"  placeholder="Nhập trạng thái">
                                @error('status')
                                <div ><code>{{ $message }}</code></div>
                                @enderror
                            </div>

                        </div>
                            <div class="form-group col-md-6">

                                <img type="hidden" width="300px" height="280px" id="blah" src="" alt="" />

                            </div>

                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Thêm</button>
                      <a class="btn btn-danger" href="{{ route('student.index') }}">Trở về</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
  </div>
@endsection
