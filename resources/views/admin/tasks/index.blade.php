@extends('admin.layouts.app')
@section('content')
<div class="row mb-2">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Quản lý yêu cầu</h1>
        @if(Auth::user()->hasPermission('Task_create'))
        <a class="btn btn-warning" href="{{ route('tasks.create') }}">Thêm mới</a>
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
            @include('admin.tasks.form-search')
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">STT</th>
                            <th>Tên sự kiện</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Giáo viên</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($items))
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{ $item->id }}.</td>
                            <td>{{ $item->event_name }}</td>
                            <td>{{ date_format(new DateTime($item->start_time), 'H:i:s - d/m/Y') ?? '' }}</td>
                            <td>{{ date_format(new DateTime($item->end_time), 'H:i:s - d/m/Y') ?? '' }}</td>
                            <td>{{ $item->teacher->name }}</td>
                            <td>{{ $item->statuses[$item->status] }}</td>
                            <td>
                                <form action="{{route('tasks.destroy',$item->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-xs btn-warning" href="{{route('tasks.edit', $item->id)}}">Sửa</a>
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
@section('footer_scripts')
@endsection