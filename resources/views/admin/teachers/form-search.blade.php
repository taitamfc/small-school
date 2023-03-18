<form action="{{ route('teachers.index') }}" method="GET" id="form-search">
    @csrf
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label>Tên</label>
                <input type="text" name="name" class="form-control"
                    placeholder="Tìm theo tên..."
                    value="{{ request()->name }}">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control"
                    placeholder="Tìm theo email..."
                    value="{{ request()->email }}">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>SDT</label>
                <input type="text" name="phone" class="form-control"
                    placeholder="Tìm theo số điện thoại..."
                    value="{{ request()->phone }}">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label style="display: block">Hành động</label>
                <input type="submit" class="btn btn-default"
                    value="Xác nhận">
            </div>
        </div>
    </div>
</form>