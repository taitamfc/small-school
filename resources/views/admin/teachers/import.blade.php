@if(Auth::user()->hasPermission('Teacher_import'))
@extends('admin.layouts.app')
@section('content')
  <div class="content-wrapper">
    <div class="container">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý giáo viên</h1><br>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('users.login') }}">Trang chủ</a></li>
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
              
                    <h3 class="card-title">Nhập giáo viên</h3><br>
                  </div>
                  <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputFile">File Import</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <label class="custom-file-label" for="exampleInputFile">Chọn file</label>
                                <input type='file' class="custom-file-input" id="imgInp" name="importUser" />
                             
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Tải file lên</span>
                              </div>
                            </div>
                                @error('importTeacher')
                                    <div><code>{{ $message }}</code></div>
                                @enderror
                            </div>
                         
                        </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Nhập</button>
                      <a class="btn btn-danger" href="{{ route('teachers.index') }}">Trở về</a>
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
@endif