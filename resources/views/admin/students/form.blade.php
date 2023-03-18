<div class="row">
    <div class="form-group col-lg-4">
        <label>Họ và tên *</label>
        <input class="form-control" name="name" value="{{ old('name') ?? $item->name  }}">
        @error('name') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Số điện thoại *</label>
        <input class="form-control"  name="phone" value="{{ old('phone') ?? $item->phone }}">
        @error('phone') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>E-mail *</label>
        <input class="form-control" name="email" value="{{ old('email') ?? $item->email }}">
        @error('email') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Ngày sinh *</label>
        <input type="date" class="form-control" name="birthday" value="{{ old('birthday') ?? $item->birthday }}">
        @error('birthday') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Nội dung khóa học</label>
        <input class="form-control" name="course_content" value="{{ old('course_content') ?? $item->course_content }}">
        @error('course_content') @include('global_layouts.error') @enderror
    </div>
    
    <div class="form-group col-lg-4">
        <label>Khóa học</label>
        <select class="form-control" name="course_id">
            <option value="0">0</option>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label>Lớp</label>
        <select class="form-control" name="room_id">
            @foreach( $rooms as $key => $val )
            <option @selected($item->room_id == $val->id)
                value="{{ $val->id }}">{{ $val->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label>Tình Trạng</label>
        <select class="form-control" name="status">
            @foreach( $item->statuses as $key => $val )
            <option @selected($item->status == $key)
                value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label>Học phí</label>
        <input type="number" class="form-control"  name="fee" value="{{ old('fee') ?? $item->fee }}">
        @error('fee') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Nợ</label>
        <input type="number" class="form-control"  name="debt" value="{{ old('debt') ?? $item->debt }}">
        @error('debt') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Tên Saler</label>
        <select class="form-control" name="saler_id">
            @foreach( $salers as $key => $value )
            <option @selected($item->saler_id == $value->id)
                value="{{ $value->id }}">{{ $value->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label>Tên Student care</label>
        <select class="form-control select2" name="student_care_id">
            @foreach( $student_carers as $key => $value )
            <option @selected($item->student_care_id == $value->id)
                value="{{ $value->id }}">{{ $value->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label>Tên GV</label>
        <select class="form-control select2" name="teacher_id">
            @foreach( $teachers as $key => $value )
            <option @selected($item->teacher_id == $value->id)
                value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group col-lg-4">
        <label>Ngày bắt đầu</label>
        <input type="date" class="form-control" name="start_date" value="{{ old('start_date') ?? $item->start_date }}">
        @error('start_date') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Ngày kết thúc</label>
        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') ?? $item->end_date }}">
        @error('end_date') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Ngày thi dự kiến</label>
        <input type="date" class="form-control" name="exercise_date" value="{{ old('exercise_date') ?? $item->exercise_date }}">
        @error('exercise_date') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Folder lộ trình</label>
        <input class="form-control" name="link_folder" value="{{ old('link_folder') ?? $item->link_folder }}">
        @error('link_folder') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Link lịch học</label>
        <input class="form-control" name="link_calendar" value="{{ old('link_calendar') ?? $item->link_calendar }}">
        @error('link_calendar') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-8">
        <label>Ghi chú</label>
        <textarea name="note" class="form-control">{{ old('note') ?? $item->note }}</textarea>
        @error('note') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Ảnh</label>
        @if( $item->image )
            <img width="100" height="100" src="{{ asset($item->image) ?? '' }}"/>
        @endif
        <input type="file" class="form-control" name="image">
        @error('image') @include('global_layouts.error') @enderror
    </div>
</div>