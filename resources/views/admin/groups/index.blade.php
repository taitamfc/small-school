@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý chức vụ</h1>
        @if(Auth::user()->hasPermission('Group_create'))
        <a class="btn btn-warning" href="{{ route('groups.create') }}">Thêm mới</a>
        @endif
        <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseExample">
            Tìm kiếm chi tiết
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('global_layouts.alert')
        <div class="collapse" id="collapseExample">
            @include('admin.groups.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên chức vụ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $group)
                        <tr>
                            <td>{{ $key + 1 }}.</td>
                            <td>{{ $group->name }}</td>
                            <td>
                                <form action="{{ route('groups.destroy',$group->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-warning" href="{{ route('groups.edit',$group->id) }}">Chỉnh sửa
                                        quyền</a>
                                    <button class="btn btn-danger" type="submit"
                                        onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa chức vụ</button>
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