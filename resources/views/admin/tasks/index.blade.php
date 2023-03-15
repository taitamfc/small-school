
@if(Auth::user()->hasPermission('Student_viewAny'))
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
                  <li class="breadcrumb-item active">Quản lý yêu cầu</li>
                </ol>
              </div>
            </div>
            <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Quản lý yêu cầu</h1><br>
              @if(Auth::user()->hasPermission('Student_create'))
              <a class="btn btn-warning" href="{{ route('tasks.create') }}">Thêm yêu cầu </a>
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
                    <div class="collapse" id="collapseExample">
                      <div class="col-12">
                          <section class="content">
                              <div class="container-fluid">
                                  <form action="{{ route('tasks.index') }}" method="GET" id="form-search">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="row">
                                   
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Tên sự kiện</label>
                                                          <input type="text" name="event_name" class="form-control"
                                                              placeholder="Tìm theo tên sự kiện" value="{{ request()->event_name }}">
                                                      </div>
                                                  </div>
                                                  
      
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Giáo viên</label>
                                                          <select class="select2" name="teacher_id" style="width: 100%;">
                                                              <option value="">--Chọn giáo viên--</option>
                                                              @foreach ($teachers as $teacher)
                                                                  <option
                                                                      <?= request()->teacher_id == $teacher->id ? 'selected' : '' ?>
                                                                      value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Trạng thái</label>
                                                          <select class="select2" name="status" style="width: 100%;">
                                                              <option value="">--Chọn trạng thái--</option>
                                                              @foreach ($item->statuses as $status => $lb_status)
                                                                  <option <?= request()->status == $status ? 'selected' : '' ?>
                                                                      value="{{ $status }}">{{ $lb_status }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Ngày bắt đầu</label>
                                                          <input type="date" name="start_time" class="form-control"
                                                              placeholder="Ngày bắt đầu" value="{{ request()->start_time }}">
                                                      </div>
                                                  </div>
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Ngày kết thúc</label>
                                                          <input type="date" name="end_time" class="form-control"
                                                              placeholder="Ngày kết thúc" value="{{ request()->end_time }}">
                                                      </div>
                                                  </div>
                                                  <div class="col-3">
                                                      <div class="form-group">
                                                          <label>Sắp xếp</label>
                                                          <select class="select2" name="orderby" style="width: 100%;">
                                                              <option value="">--Chọn sắp xếp--</option>
                                                              <option <?= request()->orderby == 'ASC' ? 'selected' : '' ?>
                                                                  value="ASC">Tăng dần</option>
                                                              <option <?= request()->orderby == 'DESC' ? 'selected' : '' ?>
                                                                  value="DESC">Giảm dần</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label>Thao tác</label>
                                                      <div class="input-group">
                                                          <div class="input-group-append">
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
                              </div>
                          </section>
                      </div>
                  </div>


                <div class="card card card-primary">
                  <div class="card-header">

                    <h3 class="card-title">Danh sách yêu cầu</h3>

                  </div>
                  <div class="card-body p-0">
                    <table class="table" style="text-align: center">
                      <thead>
                        <tr>
                          <th style="width: 10%">STT</th>
                          <th>Tên sự kiện</th>
                          <th>Bắt đầu</th>
                          <th>Kết thúc</th>
                          <th>Giáo viên</th>
                          <th>Trạng thái</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(!empty($items))
                        @foreach($items as $key => $item)
                        <tr>
                          <td>{{ $item->id }}.</td>
                          <td >{{ $item->event_name }}</td>
                          <td >{{ date_format(new DateTime($item->start_time), 'H:i:s - d/m/Y') ?? '' }}</td>
                            <td >{{ date_format(new DateTime($item->end_time), 'H:i:s - d/m/Y') ?? '' }}</td>
                            <td >{{ $item->teacher->name }}</td>
                            <td >{{ $item->statuses[$item->status] }}</td>
                            <td >
                                <form action="{{route('tasks.destroy',$item->id)}}" method="post">
                                    @method('DELETE')
                                @csrf
                                <a class="btn btn-warning" href="{{route('tasks.edit', $item->id)}}">Sửa</a>
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</button>
                            </form></td>
                        </tr>
                        @endforeach
                      @endif
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

