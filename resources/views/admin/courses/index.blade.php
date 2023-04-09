@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý khóa học</h1>
        @if(Auth::user()->hasPermission('Course_create'))
        <a class="btn btn-warning" href="{{ route('courses.create') }}">Thêm</a>
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
        @include('admin.courses.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table" >
                    <thead>
                        <tr>
                            <th style="width: 10%">STT</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{  $item->statuses[$item->status] }}</td>
                            <td>
                                <form action="{{ route('courses.destroy',$item->id) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    @if(Auth::user()->hasPermission('Course_update'))
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('courses.edit',$item->id) }}">Sửa</a>
                                    @endif
                                    @if(Auth::user()->hasPermission('Course_delete'))
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
