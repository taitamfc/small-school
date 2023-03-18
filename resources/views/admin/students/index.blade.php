@if(Auth::user()->hasPermission('Student_viewAny'))
@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>
@endsection
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
        <button class="btn btn-success" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
                                    <a class="btn btn-warning"
                                        href="{{route('students.edit', $item->id)}}">Sửa</a>
                                    <button class="btn btn-danger" type="submit"
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
@section('footer_scripts')
<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>
@endsection
@endif