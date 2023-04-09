@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý học viên</h1>
        @if(Auth::user()->hasPermission('Student_create'))
        <a class="btn btn-warning" href="{{ route('students.create') }}">Thêm học viên </a>
        @endif
        @if(Auth::user()->hasPermission('Student_export'))
        <a class="btn btn-info" href="{{ route('students.export') }}">Xuất Excel</a>
        @endif
        @if(Auth::user()->hasPermission('Student_import'))
        <a class="btn btn-primary" href="{{ route('students.viewImport') }}">Nhập Excel</a>
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
        @include('admin.students.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table" style="text-align: center">
                    <thead>
                        <tr>
                            <th style="width: 10%">STT</th>
                            <th>Họ và tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Hành động </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($items) )
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->statuses[$item->status] }}</td>
                            <td>
                                <form action="{{route('students.destroy',$item->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-xs btn-warning"
                                        href="{{route('students.edit', $item->id)}}">Sửa</a>
                                    <button class="btn btn-xs btn-danger" type="submit"
                                        onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
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