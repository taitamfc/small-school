@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
@endsection
@section('content')
  <div class="content-wrapper">
    <div class="container"><br>
        <div class="card">
            <div class="card-header">
                <h4><b>Thêm sự kiện</b></h4>
            </div>
        
            <div class="card-body">
                <form action="{{ route("events.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                            <option value="{{ $teacher->id }}">
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
                        <input type="number" min="1000" value="{{ old('fee', isset($event) ? $event->fee : 100000) }}" class="form-control" name="fee" id="fee" >
                        @error('fee')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="recurrence" value="yes" id="recurrence" data-bootstrap-switch @checked(old('recurrence', 'none') === 'yes')>
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
                            <input type="checkbox" class="form-check-input" name="recurrence_days[]" value="{{ $week_day }}" id="{{ $week_day }}" data-bootstrap-switch>
                            <label class="form-check-label" for="{{ $week_day }}">{{ $week_day }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group {{ $errors->has('end_loop') ? 'has-error' : '' }}">
                        <label for="end_loop">Thời gian lặp kết thúc*</label>
                        <input type="date" id="end_loop" name="end_loop" class="form-control datetime" value="{{ old('end_time', isset($event) ? $event->end_time : '') }}">
                        @error('end_loop')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-1">
                        <input class="btn btn-danger" type="submit" value="Thêm sự kiện">
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

