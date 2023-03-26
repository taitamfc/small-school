<div class="row">
    <div class="form-group col-lg-6">
        <label>Tên</label>
        <input class="form-control" name="name" value="{{ old('name') ?? $item->name }}">
        @error('name') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-6">
        <label>Học phí</label>
        <input type="number" class="form-control"  name="price" value="{{ old('price') ?? $item->price }}">
        @error('price') @include('global_layouts.error') @enderror
    </div>    
    <div class="form-group col-lg-12">
        <label>Mô tả</label>
        <textarea name="note" class="form-control">{{ old('description') ?? $item->description }}</textarea>
        @error('description') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-12">
        <label>Nội dung khóa học</label>
        <textarea name="note" class="form-control">{{ old('content') ?? $item->content }}</textarea>
        @error('content') @include('global_layouts.error') @enderror
    </div>
    <div class="form-group col-lg-12">
        <label>Tình Trạng</label>
        <select class="form-control" name="status">
            @foreach( $item->statuses as $key => $val )
            <option @selected($item->status == $key)
                value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>
    </div>
</div>