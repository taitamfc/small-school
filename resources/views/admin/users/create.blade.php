
@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý tài khoản</h1><br>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('login') }}">Trang chủ</a></li>
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
              
                    <h3 class="card-title">Thêm tài khoản</h3><br>
                  </div>
                  <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
    
                            <div class="form-group col-md-4">
                              <label>Họ và tên</label>
                              <input type="text" class="form-control" name="full_name" value="{{ old('full_name') ? old('full_name') : request()->full_name }}" placeholder="Nhập họ và tên">
                              @error('full_name')
                              <div ><code>{{ $message }}</code></div>
                            @enderror
                            </div>
          
                            <div class="form-group col-md-4">
                              <label>Tên đăng nhập</label>
                              <input type="text" class="form-control" name="user_name" value="{{ old('user_name') ? old('user_name') : request()->user_name }}" placeholder="Nhập tên đăng nhập">
                              @error('user_name')
                              <div ><code>{{ $message }}</code></div>
                          @enderror
                            </div>
    
                            <div class="form-group col-md-4">
                                <label>Mật khẩu</label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') ? old('password') : request()->password }}"  placeholder="Nhập mật khẩu">
                                @error('password')
                                <div ><code>{{ $message }}</code></div>
                            @enderror
                              </div>
                                           
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') ? old('email') : request()->email }}"  placeholder="Nhập email">
                                @error('email')
                                <div ><code>{{ $message }}</code></div>
                            @enderror
                            </div>
    
    
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile">Ảnh đại diện</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <label class="custom-file-label" for="exampleInputFile">Chọn ảnh</label>
                                <input type='file' class="custom-file-input" id="imgInp" name="inputFile" />
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Tải ảnh lên</span>
                              </div>
                            </div>
                            </div>
                         
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Vai trò</label>
                                <select class="form-control" name="group_id" id="exampleFormControlSelect1">
                                  <option selected value="">--Chọn chức vụ--</option>
                                  @foreach ($groups as $group)
                                      <option value="{{ $group->id }}" {{ (old('group_id') ?? request()->group_id == $group->id) ? 'selected' : '' }}>
                                          {{ $group->name }}</option>
                                  @endforeach
                              </select>
                                @error('group_id')
                                <div ><code>{{ $message }}</code></div>
                              @enderror
                            </div>
    
    
                            <div class="form-group col-md-6">
                       
                                <img type="hidden" width="300px" height="280px" id="blah" src="{{ old('inputFile') ? old('inputFile') : request()->inputFile }}"  alt="" />
    
                            </div>
                         
                        </div>
                    </div>
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Thêm</button>
                      <a class="btn btn-danger" href="{{ route('users.index') }}">Trở về</a>
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