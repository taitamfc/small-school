<form action="{{ route('rooms.index') }}" method="GET" id="form-search">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" name="id"
                            class="form-control"
                            placeholder="Tìm ID"
                            value="{{ request()->id }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="name"
                            class="form-control"
                            placeholder="Tìm theo tên lớp"
                            value="{{ request()->name }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Sắp xếp</label>
                        <select class="select2" name="orderby"
                            style="width: 100%;">
                            <option value="">--Chọn sắp xếp--</option>
                            <option
                                <?= request()->orderby == 'ASC' ? 'selected' : '' ?>
                                value="ASC">Tăng dần</option>
                            <option
                                <?= request()->orderby == 'DESC' ? 'selected' : '' ?>
                                value="DESC">Giảm dần</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Hành động</label>
                        <div class="input-group-append" style="justify-content: center">
                            <button type="submit" class="btn btn-default">
                                Xác nhận
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>