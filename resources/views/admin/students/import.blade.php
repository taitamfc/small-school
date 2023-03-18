@extends('admin.layouts.master')
@section('content')
<div class="row">
	<div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Nhập từ file</h1>
    </div>
    <div class="col-md-12">
        <div class="card">
            @include('global_layouts.alert')
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
					<div class="form-group">
						<label>File Import</label>
						<div class="input-group">
							<div class="custom-file">
								<label class="custom-file-label" for="exampleInputFile">Chọn file</label>
								<input type='file' class="custom-file-input" id="imgInp" name="importUser" />
							</div>
						</div>
						@error('importUser')
						@include('global_layouts.error')
						@enderror
					</div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Nhập</button>
                    <a class="btn btn-danger" href="{{ route('students.index') }}">Trở về</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection