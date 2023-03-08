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
                    <div ><code>{{ $message }}</code></div>
                @enderror
                   
                    </div>
                    <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                        <label for="start_time">Thời gian bắt đầu*</label>
                        <input type="datetime-local" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($event) ? $event->start_time : '') }}">
                        @error('start_time')
                        <div ><code>{{ $message }}</code></div>
                    @enderror
                    </div>
                    <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                        <label for="end_time">Thời gian kết thúc*</label>
                        <input type="datetime-local" id="end_time" name="end_time" class="form-control datetime" value="{{ old('end_time', isset($event) ? $event->end_time : '') }}">
                        @error('end_time')
                        <div ><code>{{ $message }}</code></div>
                    @enderror
                    </div>

                    <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                        <label for="end_time">Giáo viên* <br>  @error('teacher_id')<code>{{ $message }}</code>@enderror</label>
                       
                      
                            <select class="select2 col-4" name="teacher_id">
                                  <option selected value="">--Chọn giáo viên--</option>
                                    @foreach ($teachers as $teacher)
                                      <option value="{{ $teacher->id }}">
                                          {{ $teacher->name }}</option>
                                    @endforeach
                                
                              </select>&emsp; Và &emsp;
                              <label for="end_time">Học viên* <br>  @error('student_id') <code>{{ $message }}</code>@enderror</label>
                             
                              <select class="select2 col-4" name="student_id">
                                  <option selected value="">--Chọn học viên--</option>
                                  @foreach ($students as $student)
                                      <option value="{{ $student->id }}">
                                          {{ $student->name }}</option>
                                  @endforeach
                             
                              </select>
            
                    </div>

                     
                    <div class="form-group {{ $errors->has('recurrence') ? 'has-error' : '' }}">
                        <label>Sự kiện lặp lại*</label>
                        <?php $arr = ['None' => 'Không lặp lại','Daily' => 'Hàng ngày','Weekly' => 'Hàng tuần','Monthly' => 'Hàng tháng'];?>
                        @foreach(App\Models\Event::RECURRENCE_RADIO as $key => $label)
                     
                                &emsp;<input id="recurrence_{{ $key }}" name="recurrence" type="radio" value="{{ $key }}" {{ old('recurrence', 'none') === (string)$key ? 'checked' : '' }}>
                                <span for="recurrence_{{ $key }}">{{ $arr[$label] ?? $label}}</span>
                         
                        @endforeach

                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="Thêm sự kiện">
                        <a class="btn btn-success" href="{{ url()->previous() }}">
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

