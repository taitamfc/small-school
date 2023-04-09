<form action="{{ route('tasks.index') }}" method="GET" id="form-search">
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-3">
                    <div class="form-group">
                        <label>Tên sự kiện</label>
                        <input type="text" name="event_name" class="form-control"
                            placeholder="Tìm theo tên sự kiện" value="{{ request()->event_name }}">
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
                <div class="col-3">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="select2" name="status" style="width: 100%;">
                            <option value="">--Chọn trạng thái--</option>
                            @foreach ($item->statuses as $status => $lb_status)
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