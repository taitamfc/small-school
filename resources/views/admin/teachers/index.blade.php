@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý giáo viên</h1>
        @if(Auth::user()->hasPermission('Teacher_create'))
        <a class="btn btn-warning" href="{{ route('teachers.create') }}">Thêm giáo viên</a>
        @endif
        @if(Auth::user()->hasPermission('Teacher_export'))
        <a class="btn btn-info" href="{{ route('teachers.export') }}">Xuất Excel</a>
        @endif
        @if(Auth::user()->hasPermission('Teacher_import'))
        <a class="btn btn-primary" href="{{ route('teachers.viewImport') }}">Nhập Excel</a>
        @endif
        <button class="btn btn-primary" data-toggle="collapse"
            data-target="#collapseExample" >
            Tìm kiếm chi tiết
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('global_layouts.alert')
        <div class="collapse" id="collapseExample">
        @include('admin.teachers.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table" style="text-align: center">
                    <thead>
                        <tr>
                            <th style="width: 10%">STT</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $teacher)
                        <tr>
                            <td>{{ $key +1 }}.</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{  $teacher->statuses[$teacher->status] }}</td>
                            <td>
                                <form action="{{ route('teachers.destroy',$teacher->id) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    @if(Auth::user()->hasPermission('Teacher_update'))
                                    <a class="btn btn-info"
                                        href="{{ route('teachers.edit',$teacher->id) }}">Sửa</a>
                                    @endif
                                    @if(Auth::user()->hasPermission('Teacher_delete'))
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
            <div class="card-footer">
                @include('global_layouts.pagination')
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
@endsection
