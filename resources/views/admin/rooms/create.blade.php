@if (Auth::user()->hasPermission('User_create'))
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

                                        <h3 class="card-title">Thêm tài khoản</h3><br>
                                    </div>
                                    <form action="{{ route('rooms.store') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="form-group col-md-4">
                                                    <label>Tên lớp học</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name') ? old('name') : request()->name }}"
                                                        placeholder="Nhập tên lớp học">
                                                    @error('name')
                                                        <div><code>{{ $message }}</code></div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-8">
                                                    <label for="description">Nhập mô tả lớp học</label>
                                                    <textarea name="description" type="text" class="form-control" id="description"
                                                        placeholder="Nhập Mô Tả Chức Vụ(Không bắt buộc)"></textarea>
                                                    @error('description')
                                                        <div><code>{{ $message }}</code></div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                            <a class="btn btn-danger" href="{{ route('rooms.index') }}">Trở về</a>
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
