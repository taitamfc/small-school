@extends('teachers.layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="row mb-2 mt-2">
            <div class="col-lg-12">
                
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
                                                <label>Tên phòng</label>
                                                <input type="text" name="room_name" class="form-control"
                                                    placeholder="Tìm theo tên phòng" value="{{ request()->room_name }}">
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
                                        <div class="col-2">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                        <thead>
                            <tr>
                                <th> Mã sự kiện </th>
                                <th> Tên sự kiện </th>
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
                                    {{ $item->name ?? '' }}
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

@endsection