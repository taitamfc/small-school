@extends('admin.layouts.master')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container"><br>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route('events.create') }}">
                        Thêm
                    </a>
                    <a class="btn btn-warning" href="{{ route('systemCalendar') }}">
                        Trang lịch
                    </a>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Tìm kiếm chi tiết
                    </button>
                </div>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="col-12">
                    <section class="content">
                        <div class="container-fluid">
                            <form action="{{ route('events.index') }}" method="GET" id="form-search">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Tên sự kiện</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Tìm theo tên sự kiện" value="{{ request()->name }}">
                                                </div>
                                            </div>
                                            

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Giáo viên</label>
                                                    <select class="select2" name="teacher_id" style="width: 100%;">
                                                        <option value="">--Chọn giáo viên--</option>
                                                        @foreach ($teachers as $teacher)
                                                            <option
                                                                <?= request()->teacher_id == $teacher->id ? 'selected' : '' ?>
                                                                value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-3">
                                                <div class="form-group">
                                                    <label>Tên phòng</label>
                                                    <input type="text" name="room_name" class="form-control"
                                                        placeholder="Tìm theo tên phòng" value="{{ request()->room_name }}">
                                                </div>
                                            </div> --}}
                                            
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Học sinh</label>
                                                    <select class="select2" name="student_id" style="width: 100%;">
                                                        <option value="">--Chọn học sinh--</option>
                                                        @foreach ($students as $student)
                                                            <option
                                                                <?= request()->student_id == $student->id ? 'selected' : '' ?>
                                                                value="{{ $student->id }}">{{ $student->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Trạng thái</label>
                                                    <select class="select2" name="status" style="width: 100%;">
                                                        <option value="">--Chọn trạng thái--</option>
                                                        @foreach ($status->statuses as $status => $lb_status)
                                                            <option <?= request()->status == $status ? 'selected' : '' ?>
                                                                value="{{ $status }}">{{ $lb_status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Ngày bắt đầu</label>
                                                    <input type="date" name="start_time" class="form-control"
                                                        placeholder="Ngày bắt đầu" value="{{ request()->start_time }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Ngày kết thúc</label>
                                                    <input type="date" name="end_time" class="form-control"
                                                        placeholder="Ngày kết thúc" value="{{ request()->end_time }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Sắp xếp</label>
                                                    <select class="select2" name="orderby" style="width: 100%;">
                                                        <option value="">--Chọn sắp xếp--</option>
                                                        <option <?= request()->orderby == 'ASC' ? 'selected' : '' ?>
                                                            value="ASC">Tăng dần</option>
                                                        <option <?= request()->orderby == 'DESC' ? 'selected' : '' ?>
                                                            value="DESC">Giảm dần</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Thao tác</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
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
            <div class="card">
                <div class="row">
                    <div class="card-header">
                  
                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                              {{ $events->appends(request()->all())->links() }}
                            </ul>
                          </div>
                    </div>
                </div>

                <div class="card-body" >
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Tên sự kiện
                                    </th>
                                    <th>Thời gian</th>
                                    <th>
                                        Lặp lại
                                    </th>
                                    <th>
                                        GV
                                    </th>
                                    <th>
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="list-events">
                                @foreach ($events as $key => $event)
                                    <tr data-entry-id="{{ $event->id}}">

                                        <td>
                                            {{ $event->id  }}
                                        </td>
                                        <td>
                                            {{ $event->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ date('H:i',strtotime($event->start_time)) }}
                                            đến {{ date('H:i',strtotime($event->end_time)) }}
                                            - {{ date('d/m/Y',strtotime($event->end_time)) }}
                                        </td>
                                        <td>
                                            {{ $event->recurrence_days}}
                                        </td>
                                        <td>
                                            {{ $event->teacher->name}}
                                        </td>
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
            </div>
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
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('event_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.events.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'asc']
                ],
                pageLength: 100,
            });
            $('.datatable-Event:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#list-events tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
