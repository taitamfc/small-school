@extends('admin.layouts.master')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="col-lg-12">
                
                <a class="btn btn-warning" href="{{ route('systemCalendar') }}">
                    Trang lịch
                </a>
                <a class="btn btn-info" href="{{ route('events.tableList') }}">
                    Bảng sự kiện
                </a>
                <button class="btn btn-primary" type="button" data-toggle="collapse" href="#collapseExample">
                    Tìm kiếm chi tiết
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="col-12">
                <form action="" method="GET" id="form-search">
                    <div class="row">
                        <div class="col-4">
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
                        <div class="col-2">
                            <div class="form-group">
                                <div><label>Hành động</label></div> 
                                <button type="submit" class="btn btn-default">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                        <thead>
                            <tr>
                                <th> Tên lớp </th>
                                <th> Buổi </th>
                                <th> Ngày học</th>
                                <th> Giáo viên</th>
                                <th> Hoàn Thành </th>
                                <th> Sỉ số </th>
                                <th> Ghi chú </th>
                            </tr>
                        </thead>
                        <tbody id="list-events">
                            @foreach ($items as $key => $item)
                            <tr data-entry-id="{{ $item->event_id ?? $item->id}}">
                                <td> {{ $item->name ?? '' }} </td>
                                <td> {{ $key + 1 }} </td>
                                <td>
                                    {{ date('H:i',strtotime($item->start_time)) }}
                                    đến {{ date('H:i',strtotime($item->end_time)) }}
                                    - {{ date('d/m/Y',strtotime($item->end_time)) }}
                                </td>
                                <td> {{ $item->teacher->name ?? '' }} </td>
                                <td>
                                    <input class="form-control make-complete" data-id="{{ $item->id }}" @checked( $item->status == 'da_hoan_thanh' ) type="checkbox" name="status" id="">
                                </td>
                                <td>{{ $item->number_join ?? 0 }}</td>
                                <td>{{ $item->note ?? '' }}</td>
                                

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer float-end">
                <div style="float:right">
                    {{ $items->appends(request()->all())->links() }}
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
            $('.select2').select2();
            $('.make-complete').on('click',function(){
                let ask = confirm('Bạn có chắc chắn cập nhật trạng thái sự kiện ?');
                if(ask){
                    let id = $(this).data('id');
                    let ajaxOption = {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '{{ route("events.changeStatus") }}',
                        data : { 
                            id: id,
                            status: this.checked
                        },
                        dataType: 'json',
                        success: function(){

                        }
                    };
                    $.ajax( ajaxOption );
                }else{
                    this.checked = false;
                }
            })
        });
    </script>
@endsection