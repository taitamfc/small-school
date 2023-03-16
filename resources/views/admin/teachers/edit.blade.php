@if(Auth::user()->hasPermission('Teacher_update'))
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

                                <h3 class="card-title">Chỉnh sửa giáo viên</h3><br>
                            </div>
                            <form action="{{ route('teachers.update',$teacher->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Họ và Tên:</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{$teacher->name}}" placeholder="Nhập họ và tên...">
                                            @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{$teacher->email}}" placeholder="Nhập email...">
                                            @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Mật khẩu:</label>
                                            <input type="password" autocomplete="off" class="form-control"
                                                name="password" placeholder="Nhập mật khẩu...">
                                            @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Số điện thoại:</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{$teacher->phone}}" placeholder="Nhập họ và tên...">
                                            @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Trình độ</label>
                                            <textarea class="form-control" name="level">{{$teacher->level}}</textarea>
                                            @error('level')
                                            <div>{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">Ảnh đại diện</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <label class="custom-file-label" for="exampleInputFile">Chọn
                                                        ảnh</label>
                                                    <input type='file' class="custom-file-input" id="imgInp"
                                                        name="inputFile" />
                                                </div>
                                                <img type="hidden" style="float: right" width="100px" height="100px" alt="Hình ảnh"
                                                id="blah1"
                                                src="{{ $teacher->image != null ? asset($teacher->image) : 'https://taytou.com/wp-content/uploads/2022/08/Avatar-trang-anime-nam-sinh-tay-chong-cam.jpg' }}"
                                                alt="" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Trạng thái</label>
                                            <select class="form-control" name="status">
                                                @foreach( $teacher->statuses as $status => $lb_status )
                                                <option @selected($teacher->status == $status)
                                                    value="{{ $status }}">{{ $lb_status }}</option>
                                                @endforeach
                                            </select>
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
@endif