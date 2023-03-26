@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h1 class="mb-2 text-uppercase">Thêm nhân viên</h1>
    </div>
    <div class="col-md-12">
        <div class="card card-primary">
            @include('global_layouts.alert')
            <form action="{{ route('users.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @include('admin.users.form')
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a class="btn btn-danger" href="{{ route('users.index') }}">Trở về</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection