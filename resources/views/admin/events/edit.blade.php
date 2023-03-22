@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container"><br>
<div class="card">
    <div class="card-header">
        <h4><b>Chỉnh sửa sự kiện</b></h4>
    </div>

    <div class="card-body">
        <form action="{{ route("events.update", [$event->id]) }}" 
            method="POST" 
            enctype="multipart/form-data" 
            @if($event->events_count || $event->event) onsubmit="return confirm('Bạn chắc chắn cập nhật?');" @endif
        >
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Tên sự kiện*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($event) ? $event->name : '') }}">
                @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                <label for="start_time">Thời gian bắt đầu*</label>
                <input type="datetime-local" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($event) ? $event->start_time : '') }}">
                @error('start_time')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                <label for="end_time">Thời gian kết thúc*</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-control datetime" value="{{ old('end_time', isset($event) ? $event->end_time : '') }}">
                @error('end_time')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group {{ $errors->has('teacher_id') ? 'has-error' : '' }}">
                <label for="teacher_id">Giáo viên*</label>
                <select class="form-control select2" name="teacher_id">
                    <option selected value="">--Chọn giáo viên--</option>
                    @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected($teacher->id == $event->teacher_id)>
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
                <input type="number" min="1000" value="{{ old('fee', isset($event) ? $event->fee : 0) }}" class="form-control" name="fee" id="fee" >
                @error('fee')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="proof">Ghi chú</label>
                <textarea class="form-control small-editor" name="proof" id="proof" >{{ old('proof', isset($event) ? $event->proof : '') }}</textarea>
                @error('proof')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="proof">Trạng thái</label>
                <select name="status" class="form-control">
                    @foreach( $event->statuses as $status => $lb_status )
                    <option 
                        @selected( $status == $event->status )
                        value="{{ $status }}"
                    >{{ $lb_status }}</option>
                    @endforeach
                </select>
            </div>


            @include('global_layouts.modal-students')
            @if( $event->event_id == NULL )
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="recurrence" value="yes" id="recurrence" data-bootstrap-switch @checked( $event->recurrence == 'yes')>
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
                    <input type="checkbox" class="form-check-input" name="recurrence_days[]" value="{{ $week_day }}" id="{{ $week_day }}" data-bootstrap-switch @checked( in_array($week_day,$event->recurrence_days)  )>
                    <label class="form-check-label" for="{{ $week_day }}">{{ $week_day }}</label>
                </div>
                @endforeach
            </div>
            <div class="form-group {{ $errors->has('end_loop') ? 'has-error' : '' }}">
                <label for="end_loop">Thời gian lặp kết thúc*</label>
                <input type="date" id="end_loop" name="end_loop" class="form-control datetime" value="{{ old('end_loop', isset($event) ? $event->end_loop : '') }}">
                @error('end_loop')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            @endif
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="update_feature" value="yes" id="update_feature" data-bootstrap-switch >
                    <label class="form-check-label" for="update_feature">Cập nhật cho những sự kiện tiếp theo</label>
                </div>
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="Cập nhật">
                <a class="btn btn-danger" href="{{ route('events.index') }}">
                    Trở về
                 </a>
            </div>
            
        </form>


    </div>
</div>
</div>
</div>
@endsection
@section('footer_scripts')
<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
$(function () {
  $('.select2').select2()
});
</script>
@endsection