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
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($event) ? $event->name : '') }}" required>
         
            </div>
            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                <label for="start_time">Bắt đầu*</label>
                <input type="text" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($event) ? $event->start_time : '') }}" required>
       
            </div>
            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                <label for="end_time">Kết thúc*</label>
                <input type="text" id="end_time" name="end_time" class="form-control datetime" value="{{ old('end_time', isset($event) ? $event->end_time : '') }}" required>
      
            </div>
            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                <label for="end_time">Giáo viên* <br>  @error('teacher_id')<code>{{ $message }}</code>@enderror</label>
               
              
                    <select class="select2 col-4" name="teacher_id">
                          <option selected value="">--Chọn giáo viên--</option>
                          @foreach ($teachers as $teacher)
                          <option value="{{ $teacher->id }}" {{ ($teacher->id == $event->teacher_id || ($event->event && $event->event->teacher_id == $teacher->id)) ? 'selected' : '' }}>
                              {{ $teacher->name }}
                          </option>
                      @endforeach
                        
                      </select>&emsp; Và &emsp;
                      <label for="end_time">Học viên* <br>  @error('student_id') <code>{{ $message }}</code>@enderror</label>
                     
                      <select class="select2 col-4" name="student_id">
                          <option selected value="">--Chọn học viên--</option>
                          @foreach ($students as $student)
                          <option value="{{ $student->id }}" {{ ($student->id == $event->student_id || ($event->event && $event->event->student_id == $student->id)) ? 'selected' : '' }}>
                              {{ $student->name }}
                          </option>
                      @endforeach
                     
                      </select>
    
            </div>
            @if(!$event->event && !$event->events_count)
                <div class="form-group {{ $errors->has('recurrence') ? 'has-error' : '' }}">
                    <label>Sự kiện lặp lại</label>
                    <?php $arr = ['None' => 'Không lặp lại','Daily' => 'Hàng ngày','Weekly' => 'Hàng tuần','Monthly' => 'Hàng tháng'];?>
                    @foreach(App\Models\Event::RECURRENCE_RADIO as $key => $label)
                            &emsp;<input id="recurrence_{{ $key }}" name="recurrence" type="radio" value="{{ $key }}" {{ old('recurrence', $event->recurrence) === (string)$key ? 'checked' : '' }}>
                            <span for="recurrence_{{ $key }}">{{ $arr[$label] ?? $label}}</span>
                    @endforeach
             
                </div>
            @else
                <input type="hidden" name="recurrence" value="{{ $event->recurrence }}">
            @endif
            <div>
                <input class="btn btn-success" type="submit" value="Cập nhật">
                <a class="btn btn-danger" href="{{ url()->previous() }}">
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