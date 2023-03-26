<form action="{{ route('users.index') }}" method="GET" id="form-search">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Tìm theo họ và tên" value="{{ request()->full_name }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Tìm theo tên đăng nhập" value="{{ request()->user_name }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Sắp xếp</label>
                        <select class="select2" name="orderby" style="width: 100%;">
                            <option value="">--Chọn sắp xếp--</option>
                            <option <?= request()->orderby == 'ASC' ? 'selected' : '' ?> value="ASC">Tăng dần</option>
                            <option <?= request()->orderby == 'DESC' ? 'selected' : '' ?> value="DESC">Giảm dần</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Chức vụ</label>
                        <select class="select2" name="group_id" style="width: 100%;">
                            <option value="">--Chọn chức vụ--</option>
                            @foreach($groups as $group)
                            <option <?= request()->group_id == $group->id ? 'selected' : '' ?> value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="email" class="form-control" placeholder="Tìm theo Email" value="{{ request()->email }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            Xác nhận
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>