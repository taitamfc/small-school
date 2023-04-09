@extends('admin.layouts.app')
@section('header_scripts')
@endsection
@section('content')

<div class="row mb-2">
    <div class="col-lg-12">
        <h1 class="mb-2 text-uppercase">Quản lý sự kiện</h1>
        <a class="btn btn-success" href="{{ route('events.create') }}">
            Thêm
        </a>
        <a class="btn btn-warning" href="{{ route('systemCalendar') }}">
            Trang lịch
        </a>
        <button class="btn btn-primary" type="button" data-toggle="collapse" href="#collapseExample">
            Tìm kiếm chi tiết
        </button>
    </div>
</div>
            
@include('global_layouts.alert')
<div class="collapse" id="collapseExample">
@include('admin.events.form-search')
</div>
<div class="card">
    <div class="card-body" >
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sự kiện</th>
                        <th>Thời gian</th>
                        <th>Lặp lại</th>
                        <th>GV</th>
                        <th>Khách</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="list-events">
                    @foreach ($events as $key => $event)
                        <tr data-entry-id="{{ $event->id}}">

                            <td>{{ $event->id  }}</td>
                            <td>{{ $event->name ?? '' }}</td>
                            <td>
                                {{ date('H:i',strtotime($event->start_time)) }}
                                đến {{ date('H:i',strtotime($event->end_time)) }}
                                <br> {{ date('d/m/Y',strtotime($event->end_time)) }}
                            </td>
                            <td>{{ str_replace(',',', ',$event->recurrence_days)  }}</td>
                            <td>{{ $event->teacher->name}}</td>
                            <td>{{ 
                                $event->students()->count() + $event->teachers()->count() + $event->users()->count()
                            }}</td>
                            <td>
                                {{-- @can('event_show') --}}
                                <a class="btn btn-xs btn-primary"
                                    href="{{ route('events.show', $event->id) }}">
                                    Xem
                                </a>
                                {{-- @endcan --}}

                                {{-- @can('event_edit') --}}
                                <a class="btn btn-xs btn-info" href="{{ route('events.edit', $event->id) }}">
                                    Sửa
                                </a>
                                {{-- @endcan --}}

                                {{-- @can('event_delete') --}}
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                    onsubmit="return confirm('{{ $event->id == null ? 'Bạn cũng muốn xóa các sự kiện lặp lại trong tương lai' : 'Bạn có muốn xóa sự kiện này' }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="Xóa">
                                </form>
                                {{-- @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
    {{ $events->appends(request()->all())->links() }}
    </div>
</div>
@endsection
@section('footer_scripts')
@endsection
