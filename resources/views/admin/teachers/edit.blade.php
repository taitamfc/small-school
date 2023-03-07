@extends('admin.layouts.master')
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

                                <h3 class="card-title">Chỉnh sửa giáo viên</h3><br>
                            </div>
                            <form action="{{ route('teachers.update',$teacher->id) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Họ và Tên:</label>
                                            <input type="text" class="form-control" name="name" value="{{$teacher->name}}" placeholder="Nhập họ và tên...">
                                            @error('name')
                                            <div><code>{{ $message }}</code></div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" name="email" value="{{$teacher->email}}" placeholder="Nhập email...">
                                            @error('email')
                                            <div><code>{{ $message }}</code></div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Mật khẩu:</label>
                                            <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu...">
                                            @error('password')
                                            <div><code>{{ $message }}</code></div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Level</label>
                                            <input type="text" class="form-control" name="level" value="{{$teacher->level}}" placeholder="Nhập level...">
                                            @error('level')
                                            <div><code>{{ $message }}</code></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Trạng thái</label>
                                            <input type="text" class="form-control" name="status" value="{{$teacher ->status}}" placeholder="...">
                                            @error('status')
                                            <div><code>{{ $message }}</code></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                    <a class="btn btn-danger" href="{{ route('teachers.index') }}">Quay lại</a>
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