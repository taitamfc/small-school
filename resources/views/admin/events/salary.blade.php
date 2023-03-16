@extends('admin.layouts.master')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="col-lg-12">
                <button class="btn btn-primary" type="button" data-toggle="collapse" href="#collapseExample">
                    Tìm kiếm chi tiết
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="col-12">
                <form action="{{ route('events.salary') }}" method="GET" id="form-search">
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
                                <th> Mã sự kiện </th>
                                <th> Tên giáo viên </th>
                                <th>Thời gian</th>
                                <th> Tiền công </th>
                                <th> Thành tiền </th>
                            </tr>
                        </thead>
                        <tbody id="list-events">
                            <?php
                            $sub_total = 0;
                            ?>
                            @foreach ($items as $key => $item)
                            <?php
                            $total = $item->fee * ($item->durration / 60);
                            $sub_total += $total;
                            ?>
                            <tr data-entry-id="{{ $item->event_id ?? $item->id}}">
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->teacher->name ?? '' }}
                                </td>
                                <td>
                                    {{ date('H:i',strtotime($item->start_time)) }}
                                    đến {{ date('H:i',strtotime($item->end_time)) }}
                                    - {{ date('d/m/Y',strtotime($item->end_time)) }}
                                </td>
                                <td>
                                    {{ number_format($item->fee) }}
                                </td>
                                <td>
                                
                                {{ number_format( $total ) }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Tổng tiền</td>
                                <td><strong>{{ number_format($sub_total) }}</strong></td>
                            </tr>
                        </tfoot>
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
@endsection