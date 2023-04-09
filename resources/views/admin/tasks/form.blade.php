<div class="row">
    <div class="col-lg-12">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">Tiêu đề*</label>
            <input type="text" id="name" name="name" class="form-control"
                value="{{ old('name', isset($item) ? $item->name : '') }}">
            @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Ghi chú</label>
            <textarea class="form-control small-editor" name="description"
                id="description">{{ isset($item) ? $item->description : '' }}</textarea>
            @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group {{ $errors->has('event_name') ? 'has-error' : '' }}">
            <label for="event_name">Tên sự kiện*</label>
            <input type="text" id="event_name" name="event_name" class="form-control"
                value="{{ old('event_name', isset($item) ? $item->event_name : '') }}">
            @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
            <label for="start_time">Thời gian bắt đầu*</label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control datetime"
                value="{{ old('start_time', isset($item) ? $item->start_time : '') }}">
            @error('start_time')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
            <label for="end_time">Thời gian kết thúc*</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control datetime"
                value="{{ old('end_time', isset($item) ? $item->end_time : '') }}">
            @error('end_time')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group {{ $errors->has('teacher_id') ? 'has-error' : '' }}">
            <label for="teacher_id">Giáo viên*</label>
            <select class="form-control select2" name="teacher_id">
                <option selected value="">--Chọn giáo viên--</option>
                @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" @selected($teacher->id ==
                    $item->teacher_id)>
                    {{ $teacher->name }}
                </option>
                @endforeach
            </select>
            @error('teacher_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="recurrence">Tiền công/giờ</label>
            <input type="number" min="1000" value="{{ old('fee', isset($item) ? $item->fee : 0) }}" class="form-control"
                name="fee" id="fee">
            @error('fee')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        @include('global_layouts.modal-students')

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="recurrence" value="1" id="recurrence" @checked(
                    $item->recurrence == 1)>
                <label class="form-check-label" for="recurrence">Sự kiện lặp lại</label>
            </div>
        </div>
        <div class="form-group" id="recurrence-wrapper" style="display:none111">
            <label>Ngày lặp</label>
            <?php
                $week_days = ['Monday','Tuesday','Wednesday','Thursday','Friday' ,'Saturday','Sunday'];
            ?>
            @foreach( $week_days as $week_day )
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="recurrence_days[]" value="{{ $week_day }}"
                    id="{{ $week_day }}" @checked( in_array($week_day,$item->recurrence_days) )>
                <label class="form-check-label" for="{{ $week_day }}">{{ $week_day }}</label>
            </div>
            @endforeach
        </div>
        <div class="form-group {{ $errors->has('end_loop') ? 'has-error' : '' }}">
            <label for="end_loop">Thời gian lặp kết thúc*</label>
            <input type="date" id="end_loop" name="end_loop" class="form-control datetime"
                value="{{ old('end_loop', isset($item) ? $item->end_loop : '') }}">
            @error('end_loop')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="proof">Trạng thái</label>
            <select name="status" class="form-control">
                @foreach( $item->statuses as $status => $lb_status )
                <option @selected( $status==($item->status) ? $item->status : '' )
                    value="{{ $status }}"
                    >{{ $lb_status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
