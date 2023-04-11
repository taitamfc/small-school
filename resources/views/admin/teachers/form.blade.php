<div class="row">
    <div class="form-group col-lg-4">
        <label>Mã GV</label>
        <input class="form-control" name="code" value="{{ old('code') ?? $item->code }}">
        @error('code') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Họ và Tên</label>
        <input class="form-control" name="name" value="{{ old('name') ?? $item->name }}">
        @error('name') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="{{old('email') ?? $item->email}}">
        @error('email') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>SĐT/Zalo</label>
        <input class="form-control" name="phone" value="{{old('phone') ?? $item->phone}}">
        @error('phone') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Ngày sinh</label>
        <input type="date" class="form-control" name="birthday" value="{{old('birthday') ?? $item->birthday}}">
        @error('birthday') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Mật khẩu:</label>
        <input type="password" class="form-control" name="password">
        @error('password') @include('global_layouts.error') @enderror
    </div>

    <div class="form-group col-lg-4">
        <label>Số CMT/CCCD</label>
        <input class="form-control" name="cmnd" value="{{old('cmnd') ?? $item->cmnd}}">
        @error('cmnd') @include('global_layouts.error') @enderror
    </div>

    <div class="form-group col-md-12">
        <label>Hộ khẩu thường trú</label>
        <textarea class="form-control" name="ho_khau">{{$item->ho_khau}}</textarea>
        @error('ho_khau') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-md-12">
        <label>Nơi ở hiện tại</label>
        <textarea class="form-control" name="address">{{$item->address}}</textarea>
        @error('address') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-md-12">
        <label>Kĩ năng</label>
        <textarea class="form-control" name="level">{{$item->level}}</textarea>
        @error('level') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Chủ tài khoản ngân hàng</label>
        <input class="form-control" name="bank_user_name" value="{{old('bank_user_name') ?? $item->bank_user_name}}">
        @error('bank_user_name') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Số tài khoản ngân hàng</label>
        <input class="form-control" name="bank_number" value="{{old('bank_number') ?? $item->bank_number}}">
        @error('bank_number') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-4">
        <label>Chi nhánh ngân hàng</label>
        <input class="form-control" name="bank_branch_name" value="{{old('bank_branch_name') ?? $item->bank_branch_name}}">
        @error('bank_branch_name') @include('global_layouts.error') @enderror
    </div>

    <div class="form-group col-lg-4">
        <label>Ảnh</label>
        @if( $item->image )
            <img width="100" height="100" src="{{ asset($item->image) ?? '' }}"/>
        @endif
        <input type="file" class="form-control" name="image">
        @error('image') @include('global_layouts.error') @enderror
    </div>
    
    <div class="form-group col-lg-4">
        <label>Đăng kí lịch làm việc</label>
        <?php
            $week_days = ['Monday','Tuesday','Wednesday','Thursday','Friday' ,'Saturday','Sunday'];
        ?>
        @foreach( $week_days as $week_day )
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="recurrence_days[]" value="{{ $week_day }}" id="{{ $week_day }}" @checked( $item->recurrence_days ? in_array($week_day,$item->recurrence_days) : false  )>
            <label class="form-check-label" for="{{ $week_day }}">{{ $week_day }}</label>
        </div>
        @endforeach
    </div>

    <div class="form-group col-lg-4">
        <label>Trạng thái</label>
        <select class="form-control" name="status">
            @foreach( $item->statuses as $status => $lb_status )
            <option @selected($item->status == $status)
                value="{{ $status }}">{{ $lb_status }}</option>
            @endforeach
        </select>
    </div>
</div>