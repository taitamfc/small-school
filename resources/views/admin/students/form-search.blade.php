<form action="{{ route('students.index') }}" method="GET" id="form-search">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="name" class="form-control"
                            placeholder="Tìm theo họ và tên"
                            value="{{ request()->name }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control"
                            placeholder="Tìm theo số điện thoại"
                            value="{{ request()->phone }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Sinh nhật</label>
                        <input type="date" name="birthday" class="form-control"
                            placeholder="Tìm theo ngày sinh"
                            value="{{ request()->birthday }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="email" class="form-control"
                        placeholder="Tìm theo Email"
                        value="{{ request()->email }}">
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