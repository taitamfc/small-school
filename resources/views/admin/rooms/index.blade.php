@if (Auth::user()->hasPermission('User_viewAny'))
    @extends('admin.layouts.master')
    @section('header_scripts')
        <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
        </script>
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
                                    <li class="breadcrumb-item active">Quản lý lớp học</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1>Quản lý lớp học</h1><br>
                                @if (Auth::user()->hasPermission('Room_create'))
                                <a class="btn btn-warning" href="{{ route('rooms.create') }}">Thêm lớp học</a>
                                @endif
                                <button class="btn btn-success" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
                                <div class="collapse  text-center" id="collapseExample">
                                    <div class="col-12">
                                        <section class="content">
                                            <div class="container-fluid">
                                                <form action="{{ route('rooms.index') }}" method="GET" id="form-search">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label>ID</label>
                                                                        <input type="text" name="id"
                                                                            class="form-control"
                                                                            placeholder="Tìm ID"
                                                                            value="{{ request()->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label>Tên đăng nhập</label>
                                                                        <input type="text" name="name"
                                                                            class="form-control"
                                                                            placeholder="Tìm theo tên lớp"
                                                                            value="{{ request()->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label>Sắp xếp</label>
                                                                        <select class="select2" name="orderby"
                                                                            style="width: 100%;">
                                                                            <option value="">--Chọn sắp xếp--</option>
                                                                            <option
                                                                                <?= request()->orderby == 'ASC' ? 'selected' : '' ?>
                                                                                value="ASC">Tăng dần</option>
                                                                            <option
                                                                                <?= request()->orderby == 'DESC' ? 'selected' : '' ?>
                                                                                value="DESC">Giảm dần</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label>Hành động</label>
                                                                        <div class="input-group-append" style="justify-content: center">
                                                                            <button type="submit" class="btn btn-default">
                                                                                Xác nhận
                                                                            </button>
                                                                        </div>
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

                                        <h3 class="card-title">Danh sách lớp học</h3>

                                        <div class="card-tools">
                                            <ul class="pagination pagination-sm float-right">
                                                {{ $rooms->appends(request()->all())->links() }}
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table" style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%">ID</th>
                                                    <th>Tên lớp</th>
                                                    @if (Auth::user()->hasPermission('Room_update') || Auth::user()->hasPermission('Room_delete'))
                                                    <th>Hành động</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rooms as $key => $room)
                                                    <tr>
                                                        <td>{{ $room->id }}</td>
                                                        <td>{{ $room->name }}</td>
                                                        <td>
                                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                @if (Auth::user()->hasPermission('Room_update'))
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('rooms.edit', $room->id) }}">Sửa</a>
                                                                @endif
                                                                @if (Auth::user()->hasPermission('Room_delete'))
                                                                <button class="btn btn-danger" type="submit"
                                                                    onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                                                                @endif
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
        <script src="{{ asset('asset/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(function() {
                $('.select2').select2()
            });
        </script>
    @endsection
@endif
