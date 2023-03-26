<div class="row">

    <div class="form-group col-md-4">
        <label>Họ và tên</label>
        <input type="text" class="form-control" value="{{ $item->full_name }}" name="full_name"
            placeholder="Nhập họ và tên">
        @error('full_name')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label>Tên đăng nhập</label>
        <input type="text" class="form-control" value="{{ $item->user_name }}" name="user_name"
            placeholder="Nhập tên đăng nhập">
        @error('user_name')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label>Mật khẩu</label>
        <input type="password" class="form-control" value="" name="password" placeholder="Nhập mật khẩu">
        @error('password')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label>Số điện thoại</label>
        <input type="text" class="form-control" value="{{ $item->phone }}" name="phone" placeholder="Nhập phone">
        @error('phone')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label>Email</label>
        <input type="text" class="form-control" value="{{ $item->email }}" name="email" placeholder="Nhập email">
        @error('email')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>


    <div class="form-group col-md-4">
        <label for="exampleInputFile">Ảnh đại diện</label>
        <div class="input-group">
            <div class="custom-file">
                <label class="custom-file-label" for="exampleInputFile">Chọn
                    ảnh</label>
                <input type='file' class="custom-file-input" id="imgInp" name="inputFile" />
            </div>
        </div>
    </div>

    <div class="form-group col-md-6">
        <label>Vai trò</label>
        <select id="inputState" class="form-control" name="group_id">
            <option selected value="">--Chọn chức vụ--</option>
            @foreach($groups as $group)
            <option <?= $item->group_id==$group->id ? 'selected' : '' ?> value="{{$group->id}}">{{$group->name}}
            </option>
            @endforeach
        </select>
        @error('group_id')
        @include('global_layouts.error')
        @enderror
    </div>
    <div class="form-group col-md-6">
        <img type="hidden" width="100px" height="100px" id="blah1"
            src="{{ $item->avatar != null ? asset($item->avatar) : 'https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png' }}"
            alt="" onerror="this.src='https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png'" />
    </div>
</div>