
@if(Auth::user()->hasPermission('User_viewAny'))
@extends('admin.layouts.master')
@section('header_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
@endsection
@section('content')
  <div class="content-wrapper">
    <div class="container">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('users.login') }}">Trang chủ</a></li>
                  <li class="breadcrumb-item active">Quản lý tài khoản</li>
                </ol>
              </div>
            </div>
            <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Quản lý tài khoản</h1><br>
              @if(Auth::user()->hasPermission('User_create'))
              <a class="btn btn-warning" href="{{ route('users.create') }}">Thêm tài khoản</a>
              @endif

              @if(Auth::user()->hasPermission('User_export'))
              <a class="btn btn-info" href="{{ route('users.export') }}">Xuất Excel</a>
              @endif

              @if(Auth::user()->hasPermission('User_import'))
              <a class="btn btn-primary" href="{{ route('users.viewImport') }}">Nhập Excel</a>
              @endif
              <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Tìm kiếm chi tiết
              </button>
      
            </div>
          </div>
          </div>
        </section>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
           
              <div class="col-md-12">
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="collapse  text-center" id="collapseExample">
             <div class="col-12"> 
                  <section class="content">
                    <div class="container-fluid">
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
                    </div>
                </section>
                </div>
              </div>
                

                <div class="card card card-primary">
                  <div class="card-header">
               
                    <h3 class="card-title">Danh sách tài khoản</h3>
    
                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        {{ $users->appends(request()->all())->links() }}
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table" style="text-align: center">
                      <thead>
                        <tr>
                          <th style="width: 10%">STT</th>
                          <th>Họ và tên</th>
                          <th>Số điện thoại</th>
                          <th>Email</th>
                        @if(Auth::user()->hasPermission('User_update') || Auth::user()->hasPermission('User_delete'))
                          <th>Hành động</th>
                        @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $key => $user)
                        <tr>
                          <td>{{ $key + 1 }}.</td>
                          <td width="20%">{{ $user->full_name }}</td>
                          <td width="20%">{{ $user->phone }}</td>
                          <td width="20%">{{ $user->email }}</td>
                            <td width="20%">
                                <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                  @if(Auth::user()->hasPermission('User_update'))
                                    <a class="btn btn-warning" href="{{ route('users.edit',$user->id) }}">Sửa</a>
                                  @endif
                                  @if(Auth::user()->hasPermission('User_delete'))
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                                  @endif
                            </form></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
  </div>
@endsection
@section('footer_scripts')
<script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    $('.select2').select2()
  });
</script>
@endsection
@endif

