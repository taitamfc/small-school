@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý nhân viên</h1>
        @if(Auth::user()->hasPermission('User_create'))
        <a class="btn btn-warning" href="{{ route('users.create') }}">Thêm tài khoản</a>
        @endif
        @if(Auth::user()->hasPermission('User_export'))
        <a class="btn btn-info" href="{{ route('users.export') }}">Xuất Excel</a>
        @endif
        @if(Auth::user()->hasPermission('User_import'))
        <a class="btn btn-primary" href="{{ route('users.viewImport') }}">Nhập Excel</a>
        @endif
        <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample">
            Tìm kiếm chi tiết
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('global_layouts.alert')
        <div class="collapse" id="collapseExample">
            @include('admin.users.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">Mã NV</th>
                            <th>Họ và tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            @if(Auth::user()->hasPermission('User_update') ||
                            Auth::user()->hasPermission('User_delete'))
                            <th>Hành động</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td width="20%">{{ $item->full_name }}</td>
                            <td width="20%">{{ $item->phone }}</td>
                            <td width="20%">{{ $item->email }}</td>
                            <td width="20%">
                                <form action="{{ route('users.destroy',$item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    @if(Auth::user()->hasPermission('User_update'))
                                    <a class="btn btn-xs btn-warning" href="{{ route('users.edit',$item->id) }}">Sửa</a>
                                    @endif
                                    @if(Auth::user()->hasPermission('User_delete'))
                                    <button class="btn btn-xs btn-danger" type="submit"
                                        onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @include('global_layouts.pagination')
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
@endsection