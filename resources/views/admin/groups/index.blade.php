
@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý chức vụ và quyền</h1><br>
                <a class="btn btn-warning" href="{{ route('groups.create') }}">Thêm thêm chức vụ</a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Trang chủ</a></li>
                  <li class="breadcrumb-item active">Quản lý chức vụ và quyền</li>
                </ol>
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
                <div class="card card card-primary">
                  <div class="card-header">
               
                    <h3 class="card-title">Danh sách chức vụ</h3>
    
                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        {{ $groups->appends(request()->all())->links() }}
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <table class="table" style="text-align: center">
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Tên chức vụ</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($groups as $key => $group)
                        <tr>
                          <td>{{ $key + 1 }}.</td>
                          <td >{{ $group->name }}</td>
                          <td>
                                <form action="{{ route('groups.destroy',$group->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" href="{{ route('groups.edit',$group->id) }}">Chỉnh sửa quyền</a>
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa chức vụ</button>
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

