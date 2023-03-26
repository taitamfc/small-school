@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Sửa khóa học</h1>
    </div>
    <div class="col-md-12">
        @include('global_layouts.alert')
        <div class="card card-primary">
            <form action="{{ route('courses.update',$item->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                    @include('admin.courses.form')
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a class="btn btn-danger" href="{{ route('courses.index') }}">Trở về</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection