<div class="row">
    <div class="form-group col-lg-12">
        <label>Tên lớp học</label>
        <input type="text" class="form-control" name="name"
            value="{{ $item->name }}" placeholder="Nhập tên lớp học">
        @error('name')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>
    <div class="form-group col-lg-12">
        <label for="description">Nhập mô tả lớp học</label>
        <textarea name="description" type="text" class="form-control"
            id="description"
            placeholder="Nhập Mô Tả Chức Vụ(Không bắt buộc)">{{ $item->description }}</textarea>
        @error('description')
        <div><code>{{ $message }}</code></div>
        @enderror
    </div>
</div>